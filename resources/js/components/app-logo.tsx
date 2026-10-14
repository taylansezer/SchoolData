import logo from '@/assets/balikesir-il-milli-egitim.png';

export default function AppLogo() {
    return (
        <div className="flex w-full items-center justify-center">
            <img
                src={logo}
                alt="Balıkesir İl Millî Eğitim Müdürlüğü"
                className="h-auto w-full object-contain"
            />
        </div>
    );
}
