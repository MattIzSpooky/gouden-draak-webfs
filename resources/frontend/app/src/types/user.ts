export type LoginCredentials = {
  badge: string;
  password: string;
}

export type User = {
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
