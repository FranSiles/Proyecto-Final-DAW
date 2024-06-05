import { Component } from '@angular/core';
import { PaginaService } from '../service/pagina-service';

@Component({
  selector: 'app-cambiar-contrasena',
  templateUrl: './cambiar-contrasena.component.html',
  styleUrls: ['./cambiar-contrasena.component.css']
})
export class CambiarContrasenaComponent {
  constructor(private paginaservice: PaginaService){}

cambiocontrasena(){

}

}
