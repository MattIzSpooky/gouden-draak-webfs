export function transformToDutchDate(ISOString: string): string {
  return new Date(ISOString).toLocaleDateString('nl');
}

export function transFormToDutchTime(ISOString: string): string {
  return new Date(ISOString).toLocaleTimeString('nl');
}
