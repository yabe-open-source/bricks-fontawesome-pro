document.getElementById('bricks-builder-iframe').addEventListener('load', function () {
    const vnode = document.querySelector('.brx-body')._vnode;

    const dataOrigFn = vnode.appContext.components['control-icon'].data;

    vnode.appContext.components['control-icon'].data = function () {
        const data = dataOrigFn.call(this);

        data.libraries.options = {
            ...data.libraries.options,
            ...{
                fontawesomeBrands: 'Fontawesome Pro - Brands',
                fontawesomeRegular: 'Fontawesome Pro - Regular',
                fontawesomeSolid: 'Fontawesome Pro - Solid',
                fontawesomeLight: 'Fontawesome Pro - Light',
                fontawesomeThin: 'Fontawesome Pro - Thin',
                fontawesomeDuotone: 'Fontawesome Pro - Duotone',
                fontawesomeSharpSolid: 'Fontawesome Pro - Sharp Solid',
                fontawesomeSharpRegular: 'Fontawesome Pro - Sharp Regular',
                fontawesomeSharpLight: 'Fontawesome Pro - Sharp Light',
            }
        };

        // sort options by name
        data.libraries.options = Object.fromEntries(
            Object.entries(data.libraries.options).sort(([, a], [, b]) => a.localeCompare(b))
        );

        data.icons = {
            ...data.icons,
            ...{
                fontawesomeLight: {},
                fontawesomeThin: {},
                fontawesomeDuotone: {},
                fontawesomeSharpSolid: {},
                fontawesomeSharpRegular: {},
                fontawesomeSharpLight: {},
            }
        };

        return data;
    }

    const createdOrigFn = vnode.appContext.components['control-icon'].created;

    vnode.appContext.components['control-icon'].created = function () {
        createdOrigFn.call(this);

        var e = this;

        e.icons.fontawesomeBrands = {};
        e.icons.fontawesomeRegular = {};
        e.icons.fontawesomeSolid = {};

        // brands
        ykf_brx_fontawesome_pro.icons.brands.forEach((function(t) {
            t = "fa-brands fa-".concat(t);
            e.icons.fontawesomeBrands[t] = '<i class="'.concat(t, '"></i>');
        }));

        // regular and sharp regular
        ykf_brx_fontawesome_pro.icons.regular.forEach((function(t) {
            t = "fa-regular fa-".concat(t);
            e.icons.fontawesomeRegular[t] = '<i class="'.concat(t, '"></i>');

            t = "fa-sharp ".concat(t);
            e.icons.fontawesomeSharpRegular[t] = '<i class="'.concat(t, '"></i>');
        }));

        // solid and sharp solid
        ykf_brx_fontawesome_pro.icons.solid.forEach((function(t) {
            t = "fa-solid fa-".concat(t);
            e.icons.fontawesomeSolid[t] = '<i class="'.concat(t, '"></i>');
            
            t = "fa-sharp ".concat(t);
            e.icons.fontawesomeSharpSolid[t] = '<i class="'.concat(t, '"></i>');
        }));

        // light and sharp light
        ykf_brx_fontawesome_pro.icons.light.forEach((function(t) {
            t = "fa-light fa-".concat(t);
            e.icons.fontawesomeLight[t] = '<i class="'.concat(t, '"></i>');

            t = "fa-sharp ".concat(t);
            e.icons.fontawesomeSharpLight[t] = '<i class="'.concat(t, '"></i>');
        }));

        // thin
        ykf_brx_fontawesome_pro.icons.thin.forEach((function(t) {
            t = "fa-thin fa-".concat(t);
            e.icons.fontawesomeThin[t] = '<i class="'.concat(t, '"></i>');
        }));

        // duotone
        ykf_brx_fontawesome_pro.icons.duotone.forEach((function(t) {
            t = "fa-duotone fa-".concat(t);
            e.icons.fontawesomeDuotone[t] = '<i class="'.concat(t, '"></i>');
        }));
    }
});
