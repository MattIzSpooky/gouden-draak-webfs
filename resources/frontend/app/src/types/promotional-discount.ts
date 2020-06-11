import {Dish} from '@/types/dish';

export type PromotionalDiscount = {
  id: number;
  price: number;
  title: string;
  text: string;
  validFrom: string;
  validTill: string;
  dishes: Dish[];
}
