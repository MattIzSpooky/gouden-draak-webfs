import {UserRoleType} from '@/types/user';

export type User = {
  id: number;
  name: string;
  badge: number;
  role: UserRoleType;
}

export type UserRequest = {
  name: string;
  badge: number;
  password: string;
  userRoleId: number;
}
