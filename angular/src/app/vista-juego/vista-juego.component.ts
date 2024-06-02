import { Component } from '@angular/core';
import { Juego } from '../interface/juego';
import { Subscription } from 'rxjs';
import { PaginaService } from '../service/pagina-service';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { Comentarios } from '../interface/comentario';
import { Valoracion } from '../interface/valoracion';
import { Usuario } from '../interface/usuario';
import { forkJoin } from 'rxjs';

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
  public comentarios:Comentarios = {texto:'',codUsuario:0,codJuego:0}
  public valoracion:Valoracion={puntuacion:0,codUsuario:0,codJuego:0}
  private suscripcion: Subscription | null = null;
  public safeTrailerUrl: SafeResourceUrl | null = null;
  comments: any[] = [];
  ratings: any[] = [];
  stars: number[] = [1, 2, 3, 4, 5];
  errorMessage: string = '';
  
  constructor(private paginaservice: PaginaService,private sanitizer: DomSanitizer,private router: Router){
    this.suscripcion = this.paginaservice.juego$.subscribe(juego => {
      this.juego = juego;
      console.log("juego enviado: ",juego)
      if (this.juego != undefined && this.juego.nombre!='') {
        localStorage.setItem('juego', JSON.stringify(this.juego));
      }
    });
    if(!localStorage.getItem('juego')){
      this.router.navigate(['/paginaprincipal']);
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
      if (this.juego.codJuego) {
        this.cargarComentariosYValoraciones(this.juego.codJuego);
      } else {
        console.error('No codJuego found in the juego object.');
      }
    }
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); 
    } 
  }
  cargarComentariosYValoraciones(codJuego: number): void {
    forkJoin({
      comentarios: this.paginaservice.obtenerComentarios(codJuego),
      valoraciones: this.paginaservice.obtenerRating(codJuego)
    }).subscribe(
      ({ comentarios, valoraciones }) => {
        this.comments = comentarios;
        this.ratings = valoraciones;

        // Asociar valoraciones a los comentarios
        this.comments.forEach(comment => {
          const valoracion = this.ratings.find(rating => rating.codUsuario === comment.codUsuario);
          comment.valoracion = valoracion ? valoracion.puntuacion : 'Sin valoración';
        });

        console.log('Comentarios obtenidos:', this.comments);
        console.log('Valoraciones obtenidas:', this.ratings);
      },
      error => {
        console.error('Error al obtener comentarios y valoraciones:', error);
        this.errorMessage = 'Error al obtener comentarios y valoraciones. Por favor, inténtelo de nuevo más tarde.';
      }
    );
  }
  /* COMENTARIOS Y valoracion */
  selectRating(rating: number) {
    this.valoracion.puntuacion = rating;
  }

  enviarComentario():void{
    const usuario=localStorage.getItem('usuario');
    const usuariorespuesta=JSON.parse(usuario||""); 
    console.log('mi usuario',usuario);
    console.log('ID del usuario guardado en el localstorage es: ',usuariorespuesta.data.codUsuario);
    this.comentarios.codUsuario=usuariorespuesta.data.codUsuario;
    this.comentarios.codJuego=this.juego.codJuego|| 0;
    this.valoracion.codJuego=this.juego.codJuego|| 0;
    this.valoracion.codUsuario=usuariorespuesta.data.codUsuario;
    console.log("Aqui esta mi objeto comentario: ",this.comentarios);
    console.log("aqui esta mi objeto puntuacion: ",this.valoracion);
    this.paginaservice.anadircomentario(this.comentarios,this.valoracion);
  }
  /*FIN COMENTARIOS Y valoracion */
}
