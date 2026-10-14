import { Head, Link, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
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

type District = {
    id: number;
    name: string;
};

type SchoolType = {
    id: number;
    name: string;
};

type Filters = {
    search: string;
    school_type_id: string | number;
    district_id: string | number;
};

type SchoolsIndexProps = {
    schools: any;
    districts: District[];
    schoolTypes: SchoolType[];
    filters: Filters;
};

export default function SchoolsIndex({
    schools,
    districts,
    schoolTypes,
    filters,
}: SchoolsIndexProps) {
    const applyFilters = (overrides: Partial<Filters>) => {
        const params = {
            search: overrides.search ?? filters.search,
            school_type_id: overrides.school_type_id ?? filters.school_type_id,
            district_id: overrides.district_id ?? filters.district_id,
        };

        router.get('/schools', params, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const [search, setSearch] = useState(filters.search);

    useEffect(() => {
        const timeout = setTimeout(() => {
            if (search !== filters.search) {
                applyFilters({ search });
            }
        }, 400);

        return () => clearTimeout(timeout);
    }, [search]);

    const goToPage = (page: number) => {
        router.get(
            '/schools',
            {
                search: filters.search,
                school_type_id: filters.school_type_id,
                district_id: filters.district_id,
                page,
            },
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    };

    const handleSearch = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const formData = new FormData(event.currentTarget);
        const searchValue = formData.get('search');
        const search = typeof searchValue === 'string' ? searchValue : '';

        applyFilters({ search });
    };

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

                    <Button asChild>
                        <Link href="/schools/create">
                            <Plus />
                            Yeni Okul
                        </Link>
                    </Button>
                </div>

                {/* Arama ve filtreler */}
                <div className="flex flex-col gap-4 md:flex-row md:items-center">
                    <form
                        onSubmit={handleSearch}
                        className="relative w-full md:max-w-sm"
                    >
                        <Search className="text-muted-foreground absolute top-1/2 left-3 size-4 -translate-y-1/2" />

                        <Input
                            type="search"
                            name="search"
                            value={search}
                            onChange={(event) => setSearch(event.target.value)}
                            placeholder="Okul ara..."
                            className="pl-9"
                        />
                    </form>

                    <Select
                        value={
                            filters.school_type_id
                                ? String(filters.school_type_id)
                                : 'all'
                        }
                        onValueChange={(value) =>
                            applyFilters({
                                school_type_id: value === 'all' ? '' : value,
                            })
                        }
                    >
                        <SelectTrigger className="w-full md:w-[180px]">
                            <SelectValue placeholder="Okul türü" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="all">Tüm türler</SelectItem>

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

                    <Select
                        value={
                            filters.district_id
                                ? String(filters.district_id)
                                : 'all'
                        }
                        onValueChange={(value) =>
                            applyFilters({
                                district_id: value === 'all' ? '' : value,
                            })
                        }
                    >
                        <SelectTrigger className="w-full md:w-[180px]">
                            <SelectValue placeholder="İlçe" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="all">Tüm ilçeler</SelectItem>

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
                </div>

                {/* Okul tablosu */}
                <div className="w-full min-w-0 rounded-xl border">
                    <Table className="table-fixed">
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[50px]">#</TableHead>
                                <TableHead className="w-[120px]">
                                    İlçe
                                </TableHead>
                                <TableHead className="w-[240px]">
                                    Okul Adı
                                </TableHead>
                                <TableHead className="w-[280px]">
                                    Okul Türü
                                </TableHead>
                                <TableHead className="w-[120px]">
                                    Kurum Kodu
                                </TableHead>
                                <TableHead className="w-[100px] text-right">
                                    Öğrenci
                                </TableHead>
                                <TableHead className="w-[100px] text-right">
                                    Öğretmen
                                </TableHead>
                                <TableHead className="w-[100px] text-right">
                                    Derslik
                                </TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            {schools.data.length > 0 ? (
                                schools.data.map(
                                    (school: any, index: number) => (
                                        <TableRow key={school.id}>
                                            <TableCell>
                                                {schools.from + index}
                                            </TableCell>

                                            <TableCell>
                                                {school.district.name}
                                            </TableCell>

                                            <TableCell className="break-words whitespace-normal">
                                                {school.name}
                                            </TableCell>

                                            <TableCell className="break-words whitespace-normal">
                                                {school.school_type.name}
                                            </TableCell>

                                            <TableCell>
                                                {school.institution_code}
                                            </TableCell>

                                            <TableCell className="text-right">
                                                {school.student_count}
                                            </TableCell>

                                            <TableCell className="text-right">
                                                {school.teacher_count}
                                            </TableCell>

                                            <TableCell className="text-right">
                                                {school.classroom_count}
                                            </TableCell>
                                        </TableRow>
                                    ),
                                )
                            ) : (
                                <TableRow>
                                    <TableCell
                                        colSpan={8}
                                        className="h-24 text-center"
                                    >
                                        Henüz okul bulunmuyor.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                {schools.last_page > 1 && (
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <p className="text-muted-foreground text-sm">
                            {schools.total} okuldan {schools.from}-{schools.to}{' '}
                            arası gösteriliyor.
                        </p>

                        <div className="flex items-center gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                disabled={!schools.prev_page_url}
                                onClick={() =>
                                    goToPage(schools.current_page - 1)
                                }
                            >
                                Önceki
                            </Button>

                            {Array.from(
                                { length: schools.last_page },
                                (_, index) => index + 1,
                            ).map((page) => (
                                <Button
                                    key={page}
                                    variant={
                                        page === schools.current_page
                                            ? 'default'
                                            : 'outline'
                                    }
                                    size="sm"
                                    onClick={() => goToPage(page)}
                                >
                                    {page}
                                </Button>
                            ))}

                            <Button
                                variant="outline"
                                size="sm"
                                disabled={!schools.next_page_url}
                                onClick={() =>
                                    goToPage(schools.current_page + 1)
                                }
                            >
                                Sonraki
                            </Button>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}
