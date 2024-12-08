const wheel = document.getElementById('wheel');
const result = document.getElementById('result');
const segments = [
  '10 000 XAF', '5 000 XAF', '20 000 XAF',
  '2 000 XAF', '15 000 XAF', '1 000 XAF',
  '50 000 XAF', '10 000 XAF'
];

let spinning = false;

function spinWheel() {
  if (spinning) return; // Empêche le lancement multiple
  spinning = true;
  result.textContent = '';

  const randomIndex = Math.floor(Math.random() * segments.length);
  const randomDeg = 360 * 3 + randomIndex * (360 / segments.length);

  wheel.style.transform = `rotate(${randomDeg}deg)`;

  setTimeout(() => {
    const winningSegment = segments[randomIndex];
    result.textContent = `Félicitations ! Vous avez gagné ${winningSegment}`;
    spinning = false;
  }, 4000);
}