import { Injectable } from '@angular/core';
import { Observable} from 'rxjs';
import { Usuario } from '../interface/usuario';
import{HttpClient, HttpHeaders} from '@angular/common/http'
import { Juego } from '../interface/juego';
import { Comentarios } from '../interface/comentario';
import { Valoracion } from '../interface/valoracion';
import { forkJoin } from 'rxjs';
import { Comentariosvaloracion } from '../interface/comentariovaloracion';


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
    formData.append('email', usuario.email|| '');
    formData.append('nombre', usuario.nomUsuario || '');
    formData.append('password', usuario.password|| '');
    formData.append('foto', usuario.foto || '');
    return this.http.post<void>(`${this.url}/registro`,formData)
  }
  obtenerJuegos(): Observable<Juego[]>{
    return this.http.get<Juego[]>(`${this.url}/juegos`);
  }
  obtenerJuego(codJuego:number):Observable<Juego>{
    console.log("mi id de juego es: ",codJuego);
    return this.http.get<Juego>(`${this.url}/juegos/${codJuego}`);
  }
  anadirJuego(juego:Juego):Observable<void>{
    console.log("mi juego que enivo: ",juego);
    const usuariorespuesta = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariorespuesta);
    const usuario = JSON.parse(usuariorespuesta || "");
    const token = usuario.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    const formData = new FormData();
    formData.append('nombre', juego.nombre);
    formData.append('descripcion', juego.descripcion);
    formData.append('pegi', juego.pegi.toString());
    formData.append('imagen', juego.imagen || '');
    formData.append('generoPrincipal', juego.generoPrincipal);
    formData.append('generoSecundario', juego.generoSecundario || '');
    formData.append('trailer', juego.trailer || '');
    formData.append('desarrollador', juego.desarrollador);
    console.log("juego que envio: ",formData);
    return this.http.post<void>(`${this.url}/juegos`,formData,{ headers });
  }
  logout(): Observable<void>{
    const usuariorespuesta = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariorespuesta);
    const usuario = JSON.parse(usuariorespuesta || "");
    const token = usuario.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.post<void>(`${this.url}/logout`, null, { headers });
  }
  obtenerusuario(codUsuario:number):Observable<Usuario>{
    const usuariorespuesta = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariorespuesta);
    const usuario = JSON.parse(usuariorespuesta || "");
    const token = usuario.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.get<Usuario>(`${this.url}/usuarios/${codUsuario}`,{ headers });
  }
  eliminarUsuario(codUsuario:number):Observable<any>{
    const usuariorespuesta = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariorespuesta);
    const usuario = JSON.parse(usuariorespuesta || "");
    const token = usuario.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    console.log("mi id es: ",codUsuario);
    return this.http.delete(`${this.url}/usuarios/${codUsuario}`,{ headers });
  }
  submitComment(comentario:Comentarios): Observable<any> {
    return this.http.post(`${this.url}/subircomentarios`, comentario);
  }

  submitRating(valoracion:Valoracion): Observable<any> {
    return this.http.post(`${this.url}/subirvaloraciones`,valoracion);
  }

  submitFeedback(comentario:Comentarios,valoracion:Valoracion): Observable<any[]> {
    return forkJoin([
      this.submitComment(comentario),
      this.submitRating(valoracion)
    ]);
  }
  obtenerComentarios(codJuego:number): Observable<Comentarios[]> {
    return this.http.get<Comentarios[]>(`${this.url}/comentarios/${codJuego}`);

  }
  obtenerValoraciones(codJuego:number): Observable<Valoracion[]> {
    return this.http.get<Valoracion[]>(`${this.url}/valoraciones/${codJuego}`);
  }

  obtenerTodasValoraciones(): Observable<Valoracion[]> {
    return this.http.get<Valoracion[]>(`${this.url}/valoracionesgrafica`);
  }
  cambiarusuario(usuario:Usuario,codUsuario:number):Observable<any>{
    const usuariopagina = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariopagina);
    const usuariorespuesta = JSON.parse(usuariopagina || "");
    const token = usuariorespuesta.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.put<any>(`${this.url}/usuarios/${codUsuario}`, usuario, { headers });
  }
  cambiarfoto(foto:File):Observable<any>{
    const usuariopagina = localStorage.getItem('usuario');
    const usuariorespuesta = JSON.parse(usuariopagina || "");
    const token = usuariorespuesta.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    console.log("esta es mi foto antes de pasarla",foto);
    const formData = new FormData();
    formData.append('foto', foto || '');
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.post<any>(`${this.url}/usuarios`, formData, { headers });
  }
  cargarJuegosAleatorios(codJuego:number): Observable<Juego[]>{
    return this.http.get<Juego[]>(`${this.url}/juegosaleatorios/${codJuego}`);
  }
  cargarJuegosusuario(codUsuario:number): Observable<Juego[]>{
    const usuariopagina = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariopagina);
    const usuariorespuesta = JSON.parse(usuariopagina || "");
    const token = usuariorespuesta.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.get<Juego[]>(`${this.url}/juegosusuario/${codUsuario}`,{headers});
  }
  eliminarjuego(codJuego:number):Observable<any>{
    const usuariopagina = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariopagina);
    const usuariorespuesta = JSON.parse(usuariopagina || "");
    const token = usuariorespuesta.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.delete<any>(`${this.url}/juegos/${codJuego}`,{ headers });
  }
  cargarcomentariosvaloraciones(codUsuario:number):Observable<Comentariosvaloracion[]>{
    const usuariopagina = localStorage.getItem('usuario');
    console.log("mi usuario en mi localstorage: ", usuariopagina);
    const usuariorespuesta = JSON.parse(usuariopagina || "");
    const token = usuariorespuesta.data.token;
    const caracter = token.indexOf('|');
    const tokenSinId=token.substring(caracter + 1);
    console.log("desde mi laravel service Token desde localStorage:", token);
    console.log("desde mi laravel service mi token sin el id es: ",tokenSinId);
    const headers = new HttpHeaders().set('Authorization', `Bearer ${tokenSinId}`);
    return this.http.get<any>(`${this.url}/comentariosyvaloracines/${codUsuario}`,{ headers });
  }
  obtenerMediaValoraciones(codJuego: number): Observable<{ media: number }> {
    return this.http.get<any>(`${this.url}/mediaValoracionesJuego/${codJuego}`);
  }
  conseguircomentario(codUsuario:number,codJuego:number): Observable<Comentarios>{
    return this.http.get<Comentarios>(`${this.url}/vercomentario/${codUsuario}/${codJuego}`)
  }
}
