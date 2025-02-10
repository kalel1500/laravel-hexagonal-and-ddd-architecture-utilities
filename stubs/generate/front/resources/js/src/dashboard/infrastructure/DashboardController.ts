import { route } from "ziggy-js";
import { g } from "@kalel1500/laravel-ts-utils";

export default class DashboardController {
    posts() {
        const $select = document.getElementById('selectTags');
        $select?.addEventListener('change', e => {
            const $element = e.target as HTMLSelectElement|null;
            const params = g.isEmpty($element?.value) ? {} : {_query: { tag: $element?.value }};
            window.location.href = route('dashboard', params);
        });
    }
}
