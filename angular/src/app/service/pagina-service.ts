import { Injectable } from '@angular/core';
import { Usuario } from '../interface/usuario';
import { BehaviorSubject, Subject } from 'rxjs';
import {LaravelService} from './laravel.service'
import { tap } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class PaginaService {
    private _usuario = new Subject<Usuario>();
    usuario$=this._usuario.asObservable();

    anadirUsuario(usuario:Usuario){
      console.log("hola recibo: ",usuario)
    }
}