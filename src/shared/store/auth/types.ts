import {User} from "@/shared/store/profile/types";

export enum AuthStateType {
  LOGGED_OFF = "logged_off",
  LOGGING_IN = "pending",
  LOGGED_IN = "logged_in"
}

export interface AuthState{
  status:AuthStateType;
  expires:number;
  user:User|null;
}
