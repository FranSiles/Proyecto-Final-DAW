export interface Juego{
    codJuego?:number,
    nombre: string,
    descripcion: string,
    imagen: string,
    pegi: number,
    generoPrincipal: string,
    generoSecundario?: string,
    trailer?: string,
    desarrollador: string
}