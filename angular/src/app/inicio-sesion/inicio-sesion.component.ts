import { Component } from '@angular/core';
import { Subscription } from 'rxjs';
import { Usuario } from '../interface/usuario';
import { PaginaService } from '../service/pagina-service';


@Component({
  selector: 'app-inicio-sesion',
  templateUrl: './inicio-sesion.component.html',
  styleUrls: ['./inicio-sesion.component.css']
})
export class InicioSesionComponent {
  public usuario: Usuario = { email: '', password: '' };
  private suscripcion: Subscription | null = null;
  constructor(private paginaservice: PaginaService){ }
  ngOnInit() {
    this.suscripcion = this.paginaservice.usuario$.subscribe(usuario => {
      this.usuario = usuario;
    });
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); // Evita fugas de memoria al destruir el componente
    }
  }

  envioUsuario():void{
    console.log("Desde 'agregar producto' envio",this.usuario);
    this.paginaservice.anadirUsuario(this.usuario);
    this.usuario={email: '', password: ''};
  }
}
