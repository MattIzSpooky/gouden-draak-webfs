import {Dish} from '@/types/dish';

export type MenuItemApiResource = {
  data: MenuItem[];
}

export type MenuItem = {
  id: number;
  addition: string;
  dish: Dish;
  menu_number: number;
}

export type OrderedMenuItem = MenuItem & {
  amount: number;
}
