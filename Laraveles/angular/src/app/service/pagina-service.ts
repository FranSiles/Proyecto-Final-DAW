import { Injectable } from '@angular/core';
import { Usuario } from '../interface/usuario';
import { Juego } from '../interface/juego';
import { BehaviorSubject, Subject } from 'rxjs';
import {LaravelService} from './laravel.service'
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';
@Injectable({
  providedIn: 'root'
})
export class PaginaService {
    private _juegos: BehaviorSubject<Juego[]> = new BehaviorSubject<Juego[]>([]);
    private _juego = new BehaviorSubject<Juego>({nombre: '', descripcion: '', imagen: '', pegi: 0, generoPrincipal: '', generoSecundario: '', trailer: '', desarrollador: ''});
    private _usuario = new Subject<Usuario>();
    usuario$=this._usuario.asObservable();
    juegos$ = this._juegos.asObservable();
    juego$=this._juego.asObservable();
    constructor(private router: Router,private laravelservice:LaravelService){}
    verificarUsuario(usuario:Usuario){
      console.log("hola recibo: ",usuario)
      this.laravelservice.login(usuario).subscribe({
        next: (usuarioLogueado: Usuario)=>{
          console.log("Usuario logueado:", usuarioLogueado);
          this._usuario.next(usuarioLogueado);
          this.router.navigate(['/pagina-principal']);
        },
        error: (error: any) => {
          console.error("Error al registro de usuario:", error);
        }
      })
    }
    anadirUsuario(usuario:Usuario){
      console.log("añado: ",usuario)
      this.laravelservice.registro(usuario).subscribe({
        next: ()=>{
          this.router.navigate(['/inicio-sesion']);
        },
        error: (error: any) => {
          console.error("Error al registro de usuario:", error);
        }
      })
    }
    cargarJuegos(){
      this.laravelservice.obtenerJuegos().pipe(
        tap((juegos: Juego[]) => {
          this._juegos.next(juegos);
          console.log("La Consulta a la BD devuelve: ", this._juegos);
        })
      ).subscribe();
      
    }
    obtenerJuego(id:number){
      this.laravelservice.obtenerJuego(id).subscribe({
        next:(juego:Juego)=>{
          this._juego.next(juego);
          console.log("el juego recibido es ",this._juego);
          console.log("el juego recibido es ",juego);
          this.router.navigate(['/juego']); 
        },
        error: (error: any)=>{
          console.error("Error al obtener juego:", error);
        }
      })
    }
}