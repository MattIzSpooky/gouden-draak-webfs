import {Dish} from '@/types/dish';

export type MenuItemApiCollection = {
  data: MenuItem[];
}

export type MenuItem = {
  addition: string;
  dish: Dish;
  menu_number: number;
}

export type OrderedMenuItem = MenuItem & {
  amount: number;
}
