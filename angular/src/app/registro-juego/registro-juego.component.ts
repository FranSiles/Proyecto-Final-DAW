import { Component } from '@angular/core';
import { PaginaService } from '../service/pagina-service';
import { Juego } from '../interface/juego';

@Component({
  selector: 'app-registro-juego',
  templateUrl: './registro-juego.component.html',
  styleUrls: ['./registro-juego.component.css']
})
export class RegistroJuegoComponent {
  public juego: Juego = { nombre: '', descripcion: '', imagen:null, pegi:'', generoPrincipal:'', generoSecundario:'', trailer:'', desarrollador:'' };
  constructor(private paginaservice: PaginaService){ }
  onFileSelected(event: Event): void {
    const inputElement = event.target as HTMLInputElement;
    if (inputElement.files && inputElement.files.length > 0) {
      this.juego.imagen = inputElement.files[0];
    }
  }
  registroJuego(){
    console.log("Desde 'agregar usuario' envio",this.juego);
    this.paginaservice.anadirJuego(this.juego);
  }
}
