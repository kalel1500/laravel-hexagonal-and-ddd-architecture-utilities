import { C as Constants, T as Translator, H as Html, R as Route, U as UtilitiesServiceProvider } from "./vendor-aP8Z7CnL.js";
const constants = Constants.getInstance();
constants.extend({
  VITE_APP_ENV: void 0,
  VITE_APP_NAME: void 0,
  VITE_APP_STORAGE_VERSION: void 0,
  anotherSetting: "newCustomValue"
});
const test_message$1 = "Mensaje de prueba";
const test_message_VARIABLE$1 = "Mensaje de prueba con :variable";
const es = {
  test_message: test_message$1,
  test_message_VARIABLE: test_message_VARIABLE$1
};
const test_message = "Test message";
const test_message_VARIABLE = "Test message with :variable";
const en = {
  test_message,
  test_message_VARIABLE
};
const translator = Translator.getInstance();
translator.registerTranslations("es", es);
translator.registerTranslations("en", en);
class ExamplesController {
  compareHtml() {
    const $btn = document.getElementById("compareHtml");
    const $a = document.querySelector("#textarea-a");
    const $b = document.querySelector("#textarea-b");
    const $resultOk = document.getElementById("result-ok");
    const $resultNok = document.getElementById("result-nok");
    if ($a == null || $b == null || $resultOk == null || $resultNok == null) {
      throw new Error("Alguno de los elementos HTML de la pagina no se ha encontrado.");
    }
    const hideMessages = () => {
      $resultOk.classList.add("hidden");
      $resultNok.classList.add("hidden");
    };
    $a.addEventListener("focus", hideMessages);
    $b.addEventListener("focus", hideMessages);
    $btn?.addEventListener("click", (e) => {
      hideMessages();
      const htmlA = $a.value;
      const htmlB = $b.value;
      if (Html.compareHTMLElementsStructure(htmlA, htmlB)) {
        $resultOk.classList.remove("hidden");
      } else {
        $resultNok.classList.remove("hidden");
      }
    });
  }
}
function defineRoutes() {
  Route.page("hexagonal.compareHtml", [ExamplesController, "compareHtml"]);
}
UtilitiesServiceProvider.features(["registerGlobalError", "enableNotifications", "startLayoutListeners"]);
defineRoutes();
Route.dispatch();
