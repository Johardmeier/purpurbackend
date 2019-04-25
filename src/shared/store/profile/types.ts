export interface User {
  name: string;
  image:string;
  roles:string[];
}

export interface ProfileState {
  user?: User;
  error: boolean;
}