export type LoginCredentials = {
  badge: string;
  password: string;
}

export type User = {
  id: number;
  name: string;
  badge: number;
  role: UserRoleType;
}
export type UserRoleType = {
  id: number;
  name: UserRole;
  dutchName: string;
}

export const enum UserRole {
  WAITRESS = 'waitress',
  REGISTER = 'kassa',
  ADMIN = 'admin'
}

export type UserRequest = {
  name: string;
  badge: number;
  password: string;
  userRoleId: number;
}
