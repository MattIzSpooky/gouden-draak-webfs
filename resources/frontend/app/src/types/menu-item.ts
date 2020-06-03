import {Dish} from '@/types/dish';

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

export type NewMenuItemType = {
  name: string;
  price: number;
  description: string;
  dishTypeId: number;
  addition: string | null;
  menuNumber: number | null;
}

export type OrderedMenuItem = MenuItem & {
  amount: number;
}
