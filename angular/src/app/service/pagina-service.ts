import { Injectable } from '@angular/core';
import { Usuario } from '../interface/usuario';
import { BehaviorSubject, Subject } from 'rxjs';
import {LaravelService} from './laravel.service'
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';
@Injectable({
  providedIn: 'root'
})
export class PaginaService {
    private _usuario = new Subject<Usuario>();
    usuario$=this._usuario.asObservable();
    constructor(private router: Router,private laravelservice:LaravelService){}
    verificarUsuario(usuario:Usuario){
      console.log("hola recibo: ",usuario)
      this.laravelservice.login(usuario).subscribe({
        next: (usuarioLogueado: Usuario)=>{
          console.log("Usuario logueado:", usuarioLogueado);
          this._usuario.next(usuarioLogueado);
          this.router.navigate(['/pagina-principal'])
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
}