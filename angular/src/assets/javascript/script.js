anime({
    targets: '#carpeta',
    translateY: [
      { value: -50, duration: 1000, easing: 'easeInOutSine' },
      { value: 0, duration: 1000, easing: 'easeInOutSine' }
    ],
    loop: true
  });

  anime({
    targets: '#fondocuatro',
    fill: [
      { value: '#fbcc08', duration: 499 },
      { value: '#383821', duration: 501 }
    ],
    loop: true
  });

  // Obtener el elemento <path> por su ID
var path = document.getElementById('ojos2');

// Obtener el rectángulo delimitador del <path>
var bbox = path.getBBox();

// Calcular el punto central
var centerX = bbox.x + bbox.width / 2;
var centerY = bbox.y + bbox.height / 2;

console.log("Punto central X:", centerX);
console.log("Punto central Y:", centerY);

anime({
    targets: '#ojos',
  rotate: {
    value: '+=360',
    duration: 2000,
    easing: 'linear',
    },loop: true
  });
  
  
anime({
    targets: '#ojos2',
  rotate: {
    value: '-=360',
    duration: 2000,
    easing: 'linear',
    },loop: true
  });