import { Component } from '@angular/core';
import { Juego } from '../interface/juego';
import { Subscription } from 'rxjs';
import { PaginaService } from '../service/pagina-service';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';
import { Router } from '@angular/router';

@Component({
  selector: 'app-vista-juego',
  templateUrl: './vista-juego.component.html',
  styleUrls: ['./css/main.css']
})
export class VistaJuegoComponent {
  rutaImagen: string = 'assets/img/PEGI_6.svg.png';
  rutaPerfil: string = 'assets/img/omen.jpg';
  rutaFondo: string = 'assets/img/rokeli.jpg';
  public juego:Juego={nombre: '',descripcion: '',imagen: '',pegi: 0,generoPrincipal: '',generoSecundario: '',trailer: '',desarrollador: ''};
  private suscripcion: Subscription | null = null;
  public safeTrailerUrl: SafeResourceUrl | null = null;
  constructor(private paginaservice: PaginaService,private sanitizer: DomSanitizer,private router: Router){
    this.suscripcion = this.paginaservice.juego$.subscribe(juego => {
      this.juego = juego;
      console.log("juego enviado: ",juego)
      if (this.juego !== undefined && this.juego.nombre!='') {
        localStorage.setItem('juego', JSON.stringify(this.juego));
      }
    });
    if(!localStorage.getItem('juego')){
      this.router.navigate(['/pagina-principal']);/* Esto ahi que volver cuando se cierre sesion para eliminar todas las claves de localstorage*/
    }
  }
  ngOnInit() {
    const juego = localStorage.getItem('juego');
    if (juego) {
      this.juego = JSON.parse(juego);
      console.log('ID del juego guardado en localStorage: ', localStorage.getItem('juego'));
      if(this.juego.trailer){
        this.safeTrailerUrl = this.sanitizer.bypassSecurityTrustResourceUrl(this.juego.trailer || '');
      }else{
        this.safeTrailerUrl=null;
      }
      
    }
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); 
    } 
  }
}
