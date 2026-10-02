import { Head } from '@inertiajs/react';
import { Plus, Search } from 'lucide-react';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

export default function SchoolsIndex() {
    return (
        <>
            <Head title="Okullar" />

            <div className="flex flex-1 flex-col gap-6 p-4">
                {/* Sayfa başlığı */}
                <div className="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-2xl font-semibold tracking-tight">
                            Okullar
                        </h1>

                        <p className="text-muted-foreground">
                            Balıkesir ilindeki okulları görüntüleyin ve yönetin.
                        </p>
                    </div>

                    <Button>
                        <Plus />
                        Yeni Okul
                    </Button>
                </div>

                {/* Arama ve filtreler */}
                <div className="flex flex-col gap-4 md:flex-row md:items-center">
                    <div className="relative w-full md:max-w-sm">
                        <Search className="text-muted-foreground absolute top-1/2 left-3 size-4 -translate-y-1/2" />

                        <Input
                            type="search"
                            placeholder="Okul ara..."
                            className="pl-9"
                        />
                    </div>

                    <Select>
                        <SelectTrigger className="w-full md:w-[180px]">
                            <SelectValue placeholder="Okul türü" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="all">Tüm türler</SelectItem>
                            <SelectItem value="anaokulu">Anaokulu</SelectItem>
                            <SelectItem value="ilkokul">İlkokul</SelectItem>
                            <SelectItem value="ortaokul">Ortaokul</SelectItem>
                            <SelectItem value="lise">Lise</SelectItem>
                            <SelectItem value="mesleki-teknik">
                                Mesleki ve Teknik Lise
                            </SelectItem>
                        </SelectContent>
                    </Select>

                    <Select>
                        <SelectTrigger className="w-full md:w-[180px]">
                            <SelectValue placeholder="İlçe" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="all">Tüm ilçeler</SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                {/* Okul tablosu */}
                <div className="rounded-xl border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Okul Adı</TableHead>
                                <TableHead>İlçe</TableHead>
                                <TableHead>Okul Türü</TableHead>
                                <TableHead className="text-right">
                                    Öğrenci
                                </TableHead>
                                <TableHead className="text-right">
                                    Öğretmen
                                </TableHead>
                                <TableHead className="text-right">
                                    Derslik
                                </TableHead>
                                <TableHead className="text-right">
                                    İşlemler
                                </TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <TableRow>
                                <TableCell
                                    colSpan={7}
                                    className="h-24 text-center"
                                >
                                    Henüz okul bulunmuyor.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </>
    );
}
