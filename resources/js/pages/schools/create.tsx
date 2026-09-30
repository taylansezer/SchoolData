import { Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

export default function SchoolsCreate() {
    return (
        <>
            <Head title="Yeni Okul" />

            <div className="flex flex-1 flex-col gap-6 p-4">
                {/* Başlık */}
                <div className="flex items-center gap-3">
                    <Button variant="outline" size="icon" asChild>
                        <Link href="/schools">
                            <ArrowLeft />
                        </Link>
                    </Button>

                    <div>
                        <h1 className="text-2xl font-semibold tracking-tight">
                            Yeni Okul
                        </h1>

                        <p className="text-muted-foreground">
                            Sisteme yeni bir okul ekleyin.
                        </p>
                    </div>
                </div>

                {/* Form */}
                <div className="rounded-xl border p-6">
                    <div className="grid gap-6 md:grid-cols-2">

                        <div className="grid gap-2">
                            <Label htmlFor="institution_code">Kurum Kodu</Label>

                            <Input
                                id="institution_code"
                                type="number"
                                min="1"
                                placeholder="Kurum kodu"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="name">Okul Adı</Label>
                            <Input
                                id="name"
                                placeholder="Örneğin: Balıkesir Lisesi"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label>İlçe</Label>
                            <Select>
                                <SelectTrigger>
                                    <SelectValue placeholder="İlçe seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectItem value="ayvalik">
                                        Ayvalık
                                    </SelectItem>
                                    <SelectItem value="balikesir">
                                        Altıeylül
                                    </SelectItem>
                                    <SelectItem value="bandirma">
                                        Bandırma
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="grid gap-2">
                            <Label>Okul Türü</Label>
                            <Select>
                                <SelectTrigger>
                                    <SelectValue placeholder="Okul türü seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectItem value="anaokulu">
                                        Anaokulu
                                    </SelectItem>
                                    <SelectItem value="ilkokul">
                                        İlkokul
                                    </SelectItem>
                                    <SelectItem value="ortaokul">
                                        Ortaokul
                                    </SelectItem>
                                    <SelectItem value="lise">
                                        Lise
                                    </SelectItem>
                                    <SelectItem value="mesleki-teknik">
                                        Mesleki ve Teknik Lise
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="phone">Telefon</Label>
                            <Input
                                id="phone"
                                placeholder="Örneğin: 0266 123 45 67"
                            />
                        </div>

                        <div className="grid gap-2 md:col-span-2">
                            <Label htmlFor="address">Adres</Label>
                            <Input
                                id="address"
                                placeholder="Okul adresi"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="website">Web Sitesi</Label>
                            <Input
                                id="website"
                                type="url"
                                placeholder="https://..."
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="student_count">
                                Öğrenci Sayısı
                            </Label>
                            <Input
                                id="student_count"
                                type="number"
                                min="0"
                                placeholder="0"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="teacher_count">
                                Öğretmen Sayısı
                            </Label>
                            <Input
                                id="teacher_count"
                                type="number"
                                min="0"
                                placeholder="0"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="classroom_count">
                                Derslik Sayısı
                            </Label>
                            <Input
                                id="classroom_count"
                                type="number"
                                min="0"
                                placeholder="0"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="latitude">Enlem</Label>
                            <Input
                                id="latitude"
                                type="number"
                                step="any"
                                placeholder="Örneğin: 39.6484"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="longitude">Boylam</Label>
                            <Input
                                id="longitude"
                                type="number"
                                step="any"
                                placeholder="Örneğin: 27.8826"
                            />
                        </div>
                    </div>

                    <div className="mt-6 flex justify-end gap-3">
                        <Button variant="outline" asChild>
                            <Link href="/schools">İptal</Link>
                        </Button>

                        <Button type="submit">Okulu Kaydet</Button>
                    </div>
                </div>
            </div>
        </>
    );
}
