import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { InicioSesionComponent } from './inicio-sesion/inicio-sesion.component';
import { RegistroComponent } from './registro/registro.component';
import { PaginanoencontradaComponent } from './paginanoencontrada/paginanoencontrada.component';
import { PaginaPrincipalComponent } from './pagina-principal/pagina-principal.component';
import { ProfileComponent } from './pagina-principal/profile/profile.component';

@NgModule({
  declarations: [
    AppComponent,
    InicioSesionComponent,
    RegistroComponent,
    PaginanoencontradaComponent,
    PaginaPrincipalComponent,
    ProfileComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
