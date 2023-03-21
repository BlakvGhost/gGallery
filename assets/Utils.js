import { Selector } from './Dom/selector.js';
import { Rules, NativesRules, errs as Errors, initErrors } from './Form/Rules.js';

const ARIA_CONTROLS = '[data-a-control="true"]';
const ALERT_FIELD_SELECTOR = '.alert-a-form';
const ALERT_FIELD_ITEMS_SELECTOR = '.alert-item';

export class Form {
  constructor(o) {
    this.o = Selector.findOne(o);
  }

  checkRules(p, rules = Rules) {
    initErrors();
    const alertFields = Selector.normalChildren(this.o, ALERT_FIELD_SELECTOR);
    alertFields.forEach((field) => field.remove());

    const controls = Selector.normalChildren(this.o, ARIA_CONTROLS);
    for (const [name, rule] of Object.entries(rules)) {
      const control = controls.find((c) => c.name === name);
      if (control) {
        rule.rules.forEach((ruleName) => {
          const openBrace = ruleName.indexOf('{') + 1;
          const closeBrace = ruleName.indexOf('}');
          const param = ruleName.slice(openBrace, closeBrace);
          const ruleFn = NativesRules.find((r) => r.name === ruleName.slice(0, openBrace - 1));
          if (ruleFn) {
            const errorMessage = rule.errors[ruleFn.name] ?? `Erreur dans le champ ${control.name}`;
            ruleFn(param, errorMessage, control);
          }
        });
      }
    }

    const parent = Selector.findOne(p);
    if (!parent) {
      controls.forEach((control) => {
        const errors = Errors[control.name];
        if (errors) {
          const alertNode = document.createElement('div');
          alertNode.classList.add('error', 'alert-a-form');
          errors.forEach((error) => {
            const alertItem = document.createElement('div');
            alertItem.classList.add('alert-item');
            alertItem.innerHTML = `<strong>* ${error}</strong>`;
            alertItem.setAttribute('aria-labelledby', control.name);
            alertNode.appendChild(alertItem);
          });
          control.insertAdjacentElement('beforebegin', alertNode);
          control.classList.add('alert-is-invalid');
        }
      });
    } else {
      const alertNode = document.createElement('div');
      alertNode.classList.add('error', 'alert-a-form');
      for (const [name, errors] of Object.entries(Errors)) {
        errors.forEach((error) => {
          const alertItem = document.createElement('div');
          alertItem.classList.add('alert-item');
          alertItem.innerHTML = `<strong>* ${error}</strong>`;
          alertItem.setAttribute('aria-labelledby', name);
          alertNode.appendChild(alertItem);
        });
      }
      parent.appendChild(alertNode);
    }

    const alertItems = Selector.normalChildren(document, ALERT_FIELD_ITEMS_SELECTOR);
    alertItems.forEach((item) => {
      item.onclick = () => {
        Selector.findOne(`[name="${item.getAttribute('aria-labelledby')}"]`).focus();
      };
    });

    return Errors;
  }
}
