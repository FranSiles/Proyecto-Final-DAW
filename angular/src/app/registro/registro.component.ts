import { Component } from '@angular/core';
import { Usuario } from '../interface/usuario';
import { PaginaService } from '../service/pagina-service';
@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css']
})
export class RegistroComponent {
  public usuario: Usuario = { email: '', password: '',foto:null,nombre:'' };
  constructor(private paginaservice: PaginaService){ }
  onFileSelected(event: Event): void {
    const inputElement = event.target as HTMLInputElement;
    if (inputElement.files && inputElement.files.length > 0) {
      this.usuario.foto = inputElement.files[0];
    }
  }
  registroUsuario():void{
    console.log("Desde 'agregar usuario' envio",this.usuario);
    this.paginaservice.anadirUsuario(this.usuario);
    this.usuario={email: '', password: '',foto:null,nombre:''};
  }
}
