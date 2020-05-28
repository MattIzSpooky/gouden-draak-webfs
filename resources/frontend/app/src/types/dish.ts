export type Dish = {
  id: number;
  description: string;
  dish_type: DishType;
  price: number;
  name: string;
}

export type DishType = {
  id: number;
  type: DishTypeName;
}

export const enum DishTypeName {
  SOUP = 'Soep',
  APPETIZER = 'Voorgerecht',
  COMBI_DISH = 'Combinatie Gerechten (met witte rijst)',
  BAMI_NASI = 'Bami en nasi gerechten'
}
