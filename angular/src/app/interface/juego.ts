export interface Juego{
    codJuego?:number,
    nombre: string,
    descripcion: string,
    imagen: File|null|string,
    pegi: number,
    generoPrincipal: string,
    generoSecundario?: string,
    trailer?: string,
    desarrollador: string
}