import { Cookie, Html } from 'laravel-ts-utilities';

export default class ExamplesController {
    compareHtml()
    {
        // Fragmentos HTML A y B para comparar
        /*const htmlA = `
<ul id="dropdown-pages" class="hidden py-2 space-y-2">
    <li>
        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Settings</a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Kanban</a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Calendar</a>
    </li>
</ul>
`;

        const htmlB = `
<ul id="dropdown-pages" class="hidden space-y-2 py-2">
    <li>
        <a href="#" class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Settings</a>
    </li>
    <li>
        <a href="#" class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Kanban</a>
    </li>
    <li>
        <a href="#" class="group flex w-full items-center rounded-lg p-2 pl-11 text-base font-medium text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Calendar</a>
    </li>
</ul>
`;*/

        const $btn = document.getElementById('compareHtml');
        const $a = document.querySelector<HTMLTextAreaElement>('#textarea-a');
        const $b = document.querySelector<HTMLTextAreaElement>('#textarea-b');
        const $resultOk = document.getElementById('result-ok');
        const $resultNok = document.getElementById('result-nok');
        if ($a == null || $b == null || $resultOk == null || $resultNok == null) {
            throw new Error('Alguno de los elementos HTML de la pagina no se ha encontrado.');
        }
        const hideMessages = () => {
            $resultOk.classList.add('hidden');
            $resultNok.classList.add('hidden');
        };
        $a.addEventListener('focus', hideMessages);
        $b.addEventListener('focus', hideMessages);
        $btn?.addEventListener('click', e=> {
            hideMessages();
            const htmlA = $a.value;
            const htmlB = $b.value;
            if (Html.compareHTMLElementsStructure(htmlA, htmlB)) {
                $resultOk.classList.remove('hidden');
            } else {
                $resultNok.classList.remove('hidden');
            }
        });
    }

    modifyCookie() {
        document.getElementById('show-cookie-value')?.addEventListener('click', e => {
            const preferences = Cookie.new().preferences();
            console.log(preferences);
            console.log('valor actual: ' + preferences?.dark_theme);
        });

        document.getElementById('change-cookie')?.addEventListener('click', e => {
            const CookieService = Cookie.new();

            const preferences = CookieService.preferences();
            // const newValue = !preferences?.dark_mode_default;
            // this.updateUserPreference('dark_mode_default', newValue);

            CookieService.setPreference('dark_theme', !preferences?.dark_theme);
            const serializedPreferences = encodeURIComponent(JSON.stringify(preferences));
            /*g.newFetch({ url: route('hexagonal.ajax.cookie.update', {_query: {preferences: serializedPreferences}}), type: 'PUT' }).then(r  => {
                console.log(r);
            });
            console.log(`ha cambiado a ${preferences?.dark_theme}`);*/
        });
    }
}
