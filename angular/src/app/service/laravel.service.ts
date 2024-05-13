import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Usuario } from '../interface/usuario';
import{HttpClient} from '@angular/common/http'


@Injectable({
  providedIn: 'root'
})
export class LaravelService {
  private url= "http://localhost:80/api"
  constructor(private http: HttpClient) { }

  login(usuario:Usuario):Observable<Usuario>{
    return this.http.post<Usuario>(`${this.url}/anadir`, usuario);
  }
}
