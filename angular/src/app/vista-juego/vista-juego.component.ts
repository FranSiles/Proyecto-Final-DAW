import { Component } from '@angular/core';

@Component({
  selector: 'app-vista-juego',
  templateUrl: './vista-juego.component.html',
  styleUrls: ['./css/main.css']
})
export class VistaJuegoComponent {
  rutaImagen: string = 'assets/img/PEGI_6.svg.png';
  rutaPerfil: string = 'assets/img/omen.jpg';
  rutaFondo: string = 'assets/img/rokeli.jpg';
}
