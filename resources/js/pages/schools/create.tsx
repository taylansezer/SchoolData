import { FormEvent } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
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

type District = {
    id: number;
    name: string;
};

type SchoolType = {
    id: number;
    name: string;
};

type Directorate = {
    id: number;
    name: string;
};

type SchoolForm = {
    district_id: string;
    directorate_id: string;
    institution_code: string;
    school_type_id: string;
    name: string;
    ownership_type: string;
    address: string;
    phone: string;
    website: string;
    student_count: string;
    teacher_count: string;
    classroom_count: string;
    latitude: string;
    longitude: string;
};

type SchoolsCreateProps = {
    districts: District[];
    schoolTypes: SchoolType[];
    directorates: Directorate[];
};

export default function SchoolsCreate({
    districts,
    schoolTypes,
    directorates,
}: SchoolsCreateProps) {
    const { data, setData, post, processing, errors } = useForm<SchoolForm>({
        district_id: '',
        directorate_id: '',
        institution_code: '',
        school_type_id: '',
        name: '',
        ownership_type: 'resmi',
        address: '',
        phone: '',
        website: '',
        student_count: '0',
        teacher_count: '0',
        classroom_count: '0',
        latitude: '',
        longitude: '',
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();

        post('/schools');
    };

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
                <form onSubmit={submit} className="rounded-xl border p-6">
                    <div className="grid gap-6 md:grid-cols-2">
                        <div className="grid gap-2">
                            <Label htmlFor="institution_code">Kurum Kodu</Label>

                            <Input
                                id="institution_code"
                                type="number"
                                min="1"
                                placeholder="Kurum kodu"
                                value={data.institution_code}
                                onChange={(event) =>
                                    setData(
                                        'institution_code',
                                        event.target.value,
                                    )
                                }
                            />

                            {errors.institution_code && (
                                <p className="text-destructive text-sm">
                                    {errors.institution_code}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="name">Okul Adı</Label>

                            <Input
                                id="name"
                                placeholder="Örneğin: Balıkesir Lisesi"
                                value={data.name}
                                onChange={(event) =>
                                    setData('name', event.target.value)
                                }
                            />

                            {errors.name && (
                                <p className="text-destructive text-sm">
                                    {errors.name}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label>İlçe</Label>

                            <Select
                                value={data.district_id}
                                onValueChange={(value) =>
                                    setData('district_id', value)
                                }
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="İlçe seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    {districts.map((district) => (
                                        <SelectItem
                                            key={district.id}
                                            value={String(district.id)}
                                        >
                                            {district.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {errors.district_id && (
                                <p className="text-destructive text-sm">
                                    {errors.district_id}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label>Okul Türü</Label>

                            <Select
                                value={data.school_type_id}
                                onValueChange={(value) =>
                                    setData('school_type_id', value)
                                }
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Okul türü seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    {schoolTypes.map((schoolType) => (
                                        <SelectItem
                                            key={schoolType.id}
                                            value={String(schoolType.id)}
                                        >
                                            {schoolType.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {errors.school_type_id && (
                                <p className="text-destructive text-sm">
                                    {errors.school_type_id}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label>Kurum Türü</Label>

                            <Select
                                value={data.ownership_type}
                                onValueChange={(value) =>
                                    setData('ownership_type', value)
                                }
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Kurum türü seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectItem value="resmi">Resmi</SelectItem>

                                    <SelectItem value="özel">Özel</SelectItem>
                                </SelectContent>
                            </Select>

                            {errors.ownership_type && (
                                <p className="text-destructive text-sm">
                                    {errors.ownership_type}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label>Bağlı Müdürlük</Label>

                            <Select
                                value={data.directorate_id}
                                onValueChange={(value) =>
                                    setData('directorate_id', value)
                                }
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Müdürlük seçin" />
                                </SelectTrigger>

                                <SelectContent>
                                    {directorates.map((directorate) => (
                                        <SelectItem
                                            key={directorate.id}
                                            value={String(directorate.id)}
                                        >
                                            {directorate.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {errors.directorate_id && (
                                <p className="text-destructive text-sm">
                                    {errors.directorate_id}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="phone">Telefon</Label>

                            <Input
                                id="phone"
                                placeholder="Örneğin: 0266 123 45 67"
                                value={data.phone}
                                onChange={(event) =>
                                    setData('phone', event.target.value)
                                }
                            />

                            {errors.phone && (
                                <p className="text-destructive text-sm">
                                    {errors.phone}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="website">Web Sitesi</Label>

                            <Input
                                id="website"
                                type="url"
                                placeholder="https://..."
                                value={data.website}
                                onChange={(event) =>
                                    setData('website', event.target.value)
                                }
                            />

                            {errors.website && (
                                <p className="text-destructive text-sm">
                                    {errors.website}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2 md:col-span-2">
                            <Label htmlFor="address">Adres</Label>

                            <Input
                                id="address"
                                placeholder="Okul adresi"
                                value={data.address}
                                onChange={(event) =>
                                    setData('address', event.target.value)
                                }
                            />

                            {errors.address && (
                                <p className="text-destructive text-sm">
                                    {errors.address}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="student_count">
                                Öğrenci Sayısı
                            </Label>

                            <Input
                                id="student_count"
                                type="number"
                                min="0"
                                value={data.student_count}
                                onChange={(event) =>
                                    setData('student_count', event.target.value)
                                }
                            />

                            {errors.student_count && (
                                <p className="text-destructive text-sm">
                                    {errors.student_count}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="teacher_count">
                                Öğretmen Sayısı
                            </Label>

                            <Input
                                id="teacher_count"
                                type="number"
                                min="0"
                                value={data.teacher_count}
                                onChange={(event) =>
                                    setData('teacher_count', event.target.value)
                                }
                            />

                            {errors.teacher_count && (
                                <p className="text-destructive text-sm">
                                    {errors.teacher_count}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="classroom_count">
                                Derslik Sayısı
                            </Label>

                            <Input
                                id="classroom_count"
                                type="number"
                                min="0"
                                value={data.classroom_count}
                                onChange={(event) =>
                                    setData(
                                        'classroom_count',
                                        event.target.value,
                                    )
                                }
                            />

                            {errors.classroom_count && (
                                <p className="text-destructive text-sm">
                                    {errors.classroom_count}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="latitude">Enlem</Label>

                            <Input
                                id="latitude"
                                type="number"
                                step="any"
                                placeholder="Örneğin: 39.6484"
                                value={data.latitude}
                                onChange={(event) =>
                                    setData('latitude', event.target.value)
                                }
                            />

                            {errors.latitude && (
                                <p className="text-destructive text-sm">
                                    {errors.latitude}
                                </p>
                            )}
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="longitude">Boylam</Label>

                            <Input
                                id="longitude"
                                type="number"
                                step="any"
                                placeholder="Örneğin: 27.8826"
                                value={data.longitude}
                                onChange={(event) =>
                                    setData('longitude', event.target.value)
                                }
                            />

                            {errors.longitude && (
                                <p className="text-destructive text-sm">
                                    {errors.longitude}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="mt-6 flex justify-end gap-3">
                        <Button variant="outline" asChild>
                            <Link href="/schools">İptal</Link>
                        </Button>

                        <Button type="submit" disabled={processing}>
                            {processing ? 'Kaydediliyor...' : 'Okulu Kaydet'}
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
}
