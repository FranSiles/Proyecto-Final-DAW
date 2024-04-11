import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InicioSesionComponent } from './inicio-sesion/inicio-sesion.component';
import { RegistroComponent } from './registro/registro.component';
import { PaginanoencontradaComponent } from './paginanoencontrada/paginanoencontrada.component';

const routes: Routes = [
  {
    path: 'inicio-sesion', component: InicioSesionComponent
  },
  {
    path: 'registro', component: RegistroComponent
  },
  {
    path: '',
    redirectTo: 'inicio-sesion',
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
