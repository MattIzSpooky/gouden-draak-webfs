export function transformToDutchDate(ISOString: string): string {
  return new Date(ISOString).toLocaleDateString('nl');
}
