import { Head, usePage } from '@inertiajs/react';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { dashboard } from '@/routes';

export default function Dashboard() {
    const { auth } = usePage().props;

    const fullName = `${auth.user.first_name} ${auth.user.last_name}`.trim();

    return (
        <>
            <Head title="Ana Sayfa" />

            <div className="flex flex-1 flex-col gap-6 p-4">
                <div>
                    <h1 className="text-2xl font-semibold tracking-tight">
                        Hoş geldin, {fullName}
                    </h1>
                    <p className="text-muted-foreground">
                        Balıkesir SchoolData yönetim paneline hoş geldin.
                    </p>
                </div>

                <div className="grid gap-4 md:grid-cols-3">
                    <Card>
                        <CardHeader>
                            <CardTitle>Okullar</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold">—</div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>İlçeler</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold">—</div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Kullanıcılar</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-3xl font-bold">—</div>
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
            title: 'Ana Sayfa',
            href: dashboard(),
        },
    ],
};
