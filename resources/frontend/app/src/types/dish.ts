export type Dish = {
  id: number;
  description: string;
  dishType: DishType;
  price: number;
  name: string;
}

export type DishTypeResource = {
  data: DishType[];
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
