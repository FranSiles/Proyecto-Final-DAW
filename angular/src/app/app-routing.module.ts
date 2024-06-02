import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InicioSesionComponent } from './inicio-sesion/inicio-sesion.component';
import { RegistroComponent } from './registro/registro.component';
import { PaginanoencontradaComponent } from './paginanoencontrada/paginanoencontrada.component';
import { PaginaPrincipalComponent } from './pagina-principal/pagina-principal.component';
import { ProfileComponent } from './profile/profile.component';
import { VistaJuegoComponent } from './vista-juego/vista-juego.component';
import { RegistroJuegoComponent } from './registro-juego/registro-juego.component';
import { ModificarUsuarioComponent } from './modificar-usuario/modificar-usuario.component';
import { CambiarContrasenaComponent } from './cambiar-contrasena/cambiar-contrasena.component';

const routes: Routes = [
  {
    path: 'iniciosesion', component: InicioSesionComponent
  },
  {
    path: 'registro', component: RegistroComponent
  },
  {
    path: 'paginaprincipal', component: PaginaPrincipalComponent
  },
  {
    path: 'perfil',component: ProfileComponent
  },
  {
    path: 'juego', component: VistaJuegoComponent
  },
  {
    path: 'registrojuego', component:RegistroJuegoComponent
  },
  {
    path:'modificarusuario',component:ModificarUsuarioComponent
  },
  {
    path:'cambiarcontraseña',component:CambiarContrasenaComponent
  },
  {
    path: '',
    redirectTo: 'iniciosesion',
    pathMatch: 'full'
  },
  {
    path: '**',
    component: PaginanoencontradaComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
