import { Head } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { dashboard } from '@/routes';
import { Badge } from '@/components/ui/badge';

type Metrics = {
    totalAgents: number;
    totalMerchants: number;
    totalTransactions: number;
    totalVolume: number;
};

type RecentMerchant = {
    id: number;
    name: string;
    category: string;
    status: string;
    onboarded_at: string;
    agent_name: string;
    market_name: string;
};

type Props = {
    metrics: Metrics;
    recentMerchants: RecentMerchant[];
};

export default function Dashboard({ metrics, recentMerchants }: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    return (
        <>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-6">
                
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Total Agen
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{metrics.totalAgents}</div>
                            <p className="text-xs text-muted-foreground">
                                Terdaftar di sistem
                            </p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Total Merchant
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{metrics.totalMerchants}</div>
                            <p className="text-xs text-muted-foreground">
                                Telah dionboard
                            </p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Volume Transaksi
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{formatCurrency(metrics.totalVolume)}</div>
                            <p className="text-xs text-muted-foreground">
                                Akumulasi semua transaksi
                            </p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Jumlah Transaksi
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{metrics.totalTransactions}</div>
                            <p className="text-xs text-muted-foreground">
                                Frekuensi transaksi berhasil
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid gap-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>Merchant Terbaru</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm text-left">
                                    <thead className="text-xs text-muted-foreground uppercase bg-muted/50 rounded-t-lg">
                                        <tr>
                                            <th className="px-4 py-3 font-medium">Nama Merchant</th>
                                            <th className="px-4 py-3 font-medium">Kategori</th>
                                            <th className="px-4 py-3 font-medium">Pasar (Market)</th>
                                            <th className="px-4 py-3 font-medium">Agen</th>
                                            <th className="px-4 py-3 font-medium">Status</th>
                                            <th className="px-4 py-3 font-medium text-right">Tanggal Onboard</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y">
                                        {recentMerchants.map((merchant) => (
                                            <tr key={merchant.id} className="hover:bg-muted/50 transition-colors">
                                                <td className="px-4 py-3 font-medium text-foreground">{merchant.name}</td>
                                                <td className="px-4 py-3 text-muted-foreground">{merchant.category}</td>
                                                <td className="px-4 py-3 text-muted-foreground">{merchant.market_name}</td>
                                                <td className="px-4 py-3 text-muted-foreground">{merchant.agent_name}</td>
                                                <td className="px-4 py-3">
                                                    <Badge variant={merchant.status === 'active' ? 'default' : 'secondary'} className="capitalize">
                                                        {merchant.status}
                                                    </Badge>
                                                </td>
                                                <td className="px-4 py-3 text-muted-foreground text-right">{merchant.onboarded_at}</td>
                                            </tr>
                                        ))}
                                        {recentMerchants.length === 0 && (
                                            <tr>
                                                <td colSpan={6} className="px-4 py-8 text-center text-muted-foreground">
                                                    Belum ada data merchant.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
