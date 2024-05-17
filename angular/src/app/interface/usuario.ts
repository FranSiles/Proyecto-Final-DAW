export interface Usuario {
    id?: number;
    nombre?: string;
    email: string;
    password: string;
    foto?: File|null;

}
