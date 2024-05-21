import { Component } from '@angular/core';
import { Subscription } from 'rxjs';
import { PaginaService } from '../service/pagina-service';
import { Juego } from '../interface/juego';

@Component({
  selector: 'app-pagina-principal',
  templateUrl: './pagina-principal.component.html',
  styleUrls: ['./pagina-principal.component.css']
})
export class PaginaPrincipalComponent {
  public juegos:Juego[]=[];
  private suscripcion: Subscription | null = null;
  constructor(private paginaservice: PaginaService){ 
    this.paginaservice.cargarJuegos();
  }
  ngOnInit() {
    this.suscripcion = this.paginaservice.juegos$.subscribe(
      juegosNuevos => {
        this.juegos = juegosNuevos;
      });
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); 
    } 
  }

  enviarId(id:number){
    console.log("recibo el id numero: ", id)
    this.paginaservice.obtenerJuego(id);
  }

}
