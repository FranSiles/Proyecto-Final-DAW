import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Usuario } from '../interface/usuario';
import{HttpClient, HttpHeaders} from '@angular/common/http'


@Injectable({
  providedIn: 'root'
})
export class LaravelService {
  private url= "http://localhost:80/api"
  constructor(private http: HttpClient) { }

  login(usuario:Usuario):Observable<Usuario>{
    return this.http.post<Usuario>(`${this.url}/login`, usuario);
  }
  registro(usuario:Usuario):Observable<void>{
    console.log("mi usuario que enivo: ",usuario);
    const formData = new FormData();
    formData.append('email', usuario.email);
    formData.append('nombre', usuario.nombre || '');
    formData.append('password', usuario.password);
    formData.append('foto', usuario.foto || '');
    return this.http.post<void>(`${this.url}/registro`,formData)
  }
}
