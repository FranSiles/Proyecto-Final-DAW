import { Component, ElementRef, Renderer2 } from '@angular/core';
import { PaginaService } from '../service/pagina-service';
import { Usuario } from '../interface/usuario';
import { Subscription } from 'rxjs';
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {
  public usuario:Usuario={codUsuario:0, nomUsuario:'', email: '', foto:null};
  private suscripcion: Subscription | null = null;
  constructor(private paginaservice: PaginaService,private router: Router,private renderer: Renderer2,private elRef: ElementRef){}
  ngOnInit() {
    const usuariorecibido=localStorage.getItem('usuarioperfil');
    if(usuariorecibido){
      if(this.usuario.nomUsuario==""){
      this.usuario=JSON.parse(usuariorecibido ||"");
    console.log("mi usuario en perfil es: ",this.usuario);
    }
    }
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); // Evita fugas de memoria al destruir el componente
    }
  }
  volver(){
    localStorage.removeItem('usuarioperfil');
    this.router.navigate(['/paginaprincipal']);
  }
  eliminarId(codUsuario:number){
    this.paginaservice.eliminarUsuario(codUsuario);
  }

}

