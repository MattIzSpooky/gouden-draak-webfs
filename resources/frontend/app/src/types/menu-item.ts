import {Dish} from '@/types/dish';

export type MenuItemApiResource = {
  data: MenuItemsGroupedWithType[];
}

export type MenuItemsGroupedWithType = {
  type: string;
  items: MenuItem[];
}

export type MenuItem = {
  id: number;
  addition: string;
  dish: Dish;
  menuNumber: number;
}

export type OrderedMenuItem = MenuItem & {
  amount: number;
}
