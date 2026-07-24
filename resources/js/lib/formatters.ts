const rupiahFormatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
});

const dateFormatter = new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
});

const dateTimeFormatter = new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
});

export function formatRupiah(amount: number): string {
    return rupiahFormatter.format(amount);
}

export function formatDate(value: string | Date): string {
    return dateFormatter.format(new Date(value));
}

export function formatDateTime(value: string | Date): string {
    return dateTimeFormatter.format(new Date(value));
}
