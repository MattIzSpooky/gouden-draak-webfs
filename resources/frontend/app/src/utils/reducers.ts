import {OrderedMenuItem} from '@/types/menu-item';

export const calculateTotalPriceOfOrderedMenuItems = (accumulator: number, item: OrderedMenuItem) => {
  let totalDishValue = 0;
  for (let i = 0; i < item.amount; i++) {
    totalDishValue = totalDishValue + item.dish.price;
  }
  return accumulator + totalDishValue;
};
