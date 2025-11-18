<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Skincare Forum</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
body {
    margin: 0;
    height: 100vh;
    font-family: 'Figtree', sans-serif;
    background: linear-gradient(120deg, #89f7fe, #66a6ff, #fbc2eb, #a6c1ee);
    background-size: 600% 600%;
    animation: bgFlow 20s ease infinite;

    /* ⭐ Canh giữa DỌC + NGANG */
    display: flex;
    flex-direction: column;
    justify-content: center; 
    align-items: center;

    overflow: hidden; /* ❌ Không cho scroll */
}

@keyframes bgFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Tiêu đề gần form lại */
.app-title {
    font-size: 3rem;
    font-weight: 900;
    background: linear-gradient(to right, #ffb347, #ffcc33, #88d3ce);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);

    margin-bottom: 1.5rem; /* ⭐ Giảm khoảng cách */
}

/* Form gọn lại, KHÔNG SCROLL */
.glass-card {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(25px);
    border-radius: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 2rem;
    width: 100%;
    max-width: 380px;

    /* ⭐ Không quá dài để tránh scrollbar */
    max-height: fit-content;
    overflow: hidden;
    text-align: center;
}

.btn-glow {
    background: linear-gradient(45deg, #ffb347, #ffcc33, #88d3ce);
    color: white;
    border-radius: 9999px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
    margin-top: 1rem;
}
.btn-glow:hover {
    box-shadow: 0 0 20px #ffb347, 0 0 40px #ffcc33, 0 0 60px #88d3ce;
    transform: translateY(-3px);
}

/* Particle bay lung tung */
.particle, .confetti, .sparkle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 5;
    font-size: 16px;
    animation: floatUp linear infinite;
    opacity: 0.7;
}

@keyframes floatUp {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(-120vh) rotate(720deg); opacity: 0; }
}

.sparkle { z-index: 50; font-size: 14px; animation: sparkleMove 0.8s ease-out forwards; }
@keyframes sparkleMove {
    0% { transform: translate(0,0) scale(1); opacity: 1; }
    100% { transform: translate(var(--x), var(--y)) scale(0.2); opacity: 0; }
}

.confetti { top: -2rem; font-size: 16px; animation: confettiFall linear infinite; z-index: 1; }
@keyframes confettiFall {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(120vh) rotate(360deg); opacity: 0; }
}

</style>
</head>
<body>

<div class="app-title">SkincareForum</div>

<div class="glass-card">
    {{ $slot }}
    </div>

</div>

<script>
// Particle bay lung tung nền
const icons = ['❤️','⭐','✦','💖','✨','💎','💫'];
const particlesCount = 50;
for(let i=0;i<particlesCount;i++){
    const p = document.createElement('div');
    p.classList.add('particle');
    p.innerText = icons[Math.floor(Math.random()*icons.length)];
    const size = Math.random()*20 + 12;
    p.style.fontSize = size + 'px';
    p.style.left = Math.random()*100 + 'vw';
    p.style.top = Math.random()*100 + 'vh';
    const duration = Math.random()*10 + 6;
    p.style.animationDuration = duration + 's';
    document.body.appendChild(p);
}

// Sparkle effect khi hover/click vào nút
function createSparkle(e) {
    const btn = e.currentTarget;
    for(let i=0;i<8;i++){
        const s = document.createElement('div');
        s.classList.add('sparkle');
        s.innerText = icons[Math.floor(Math.random()*icons.length)];
        btn.appendChild(s);
        const angle = Math.random()*2*Math.PI;
        const distance = Math.random()*60 + 20;
        s.style.setProperty('--x', `${Math.cos(angle)*distance}px`);
        s.style.setProperty('--y', `${Math.sin(angle)*distance}px`);
        s.addEventListener('animationend', ()=> s.remove());
    }
}

document.querySelectorAll('.btn-glow').forEach(btn => {
    btn.addEventListener('mouseenter', createSparkle);
    btn.addEventListener('click', createSparkle);
});

// Confetti kim tuyến rơi
const confettiCount = 80;
for(let i=0;i<confettiCount;i++){
    const c = document.createElement('div');
    c.classList.add('confetti');
    c.innerText = icons[Math.floor(Math.random()*icons.length)];
    const size = Math.random()*18 + 10;
    c.style.fontSize = size + 'px';
    c.style.left = Math.random()*100 + 'vw';
    c.style.animationDuration = (Math.random()*8 + 5) + 's';
    c.style.animationDelay = (Math.random()*5) + 's';
    document.body.appendChild(c);
}
</script>

</body>
</html>
