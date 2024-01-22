<?php
/**
 * pelegrinroca funcion tabla de cálculo de precios
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pelegrinroca
 */

/* add_filter( 'woocommerce_is_sold_individually', 'my_remove_quantity_fields', 10, 2 );
function my_remove_quantity_fields( $return, $product ) {
    return true;
} */

add_action(
    'wp_footer',
    'converts_product_attributes_from_select_options_to_div'
);
function converts_product_attributes_from_select_options_to_div() { ?>

<script>

    /* document.addEventListener('DOMContentLoaded', () => {

        var isSingleProductPage = document.body.classList.contains('single-product');
        var formCart = document.querySelector('.variations_form.cart');
        
        if (formCart) {
            var variationsData = formCart.getAttribute('data-product_variations');
        }

        if (isSingleProductPage && variationsData) {


            // when a user clicks on a div it adds the "selected" attribute to the respective select option
            document.addEventListener('click', function(event) {
                var target = event.target;
                if (target.classList.contains('custom_option')) {
                    var parentID = target.dataset.parentId;
                    if (target.classList.contains('on')) {
                        target.classList.remove('on');
                        document.querySelector('.single-product div.product table.variations select#' + parentID).value = '';
                        triggerChangeEvent('.single-product div.product table.variations select#' + parentID);
                    } else {
                        var customOptions = document.querySelectorAll('.custom_option[data-parent-id="' + parentID + '"]');
                        customOptions.forEach(function(option) {
                            option.classList.remove('on');
                        });
                        target.classList.add('on');
                        document.querySelector('.single-product div.product table.variations select#' + parentID).value = target.dataset.value;
                        triggerChangeEvent('.single-product div.product table.variations select#' + parentID);
                    }
                }
            });

            function triggerChangeEvent(selector) {
                var event = new Event('change', { bubbles: true });
                document.querySelector(selector).dispatchEvent(event);
            }


            // if a select option is already selected, it adds the "on" attribute to the respective div
            var selectElements = document.querySelectorAll('#pa_cantidad, #pa_opciones-envio');
            selectElements.forEach(function(select) {
                var selectedValue = select.options[select.selectedIndex].value;
                if (selectedValue) {
                    var id = select.id;
                    var customOptions = document.querySelectorAll('.custom_option[data-parent-id="' + id + '"]');
                    customOptions.forEach(function(option) {
                    option.classList.remove('on');
                });
                var selectedOption = document.querySelector('.custom_option[data-parent-id="' + id + '"][data-value="' + selectedValue + '"]');
                if (selectedOption) {
                    selectedOption.classList.add('on');
                }
                }
            });


            // when the select options change based on the ones selected, it shows or hides the respective divs
            document.body.addEventListener('check_variations', function() {
                var customOptions = document.querySelectorAll('div.custom_option');
                customOptions.forEach(function(option) {
                    option.classList.remove('is-visible');
                });

                var selectElements = document.querySelectorAll('.single-product div.product table.variations select');
                selectElements.forEach(function(select) {
                    var attrID = select.id;
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        var option = options[i];
                        if (option.value !== '') {
                            var customOption = document.querySelector('div[data-parent-id="' + attrID + '"][data-value="' + option.value + '"]');
                            if (customOption) {
                                customOption.classList.add('is-visible');
                            }
                        }
                    }
                });
            });

            var datos = []; // Array para almacenar los datos
            var arrDatos = []
            const num = document.querySelector('.wpo-totals-label span.wpo-price');
            
            // Acceder al atributo data-product_variations del formulario
            // var variationsData = document.querySelector('.variations_form.cart').getAttribute('data-product_variations');
            var variationsDataParsed = JSON.parse(variationsData);
        
            var opciones = document.querySelectorAll('.wpo-radio input[type="radio"]')
        
            function calcularTabla() {
                datos = []; // Limpiar el arreglo de datos antes de llenarlo nuevamente
        
                var sumas = [];
                var calculo = [];
                arrDatos = [];
        
                if (variationsDataParsed) {
                    for (var i = 0; i < variationsDataParsed.length; i++) {
                        var variation = variationsDataParsed[i];
                        // console.log(variation);
                        // var atributos = Object.keys(variation.attributes)
                        var dato = {};
                        dato.nombre1 = variation.attributes['attribute_pa_cantidad'];
                        dato.nombre2 = variation.attributes['attribute_pa_opciones-envio'];
                        dato.precio = parseFloat(variation.display_price);
                        datos.push(dato);
                        // console.log(dato.precio);
                    }

                    datos = datos.map(dato => ({ nombre1: dato.nombre1, nombre2: dato.nombre2, precio: parseFloat(dato.precio) }));

                    // console.log(datos);
                }


        
                for (let i = 0; i < datos.length; i++) {
                    var pre = { precio: 0 };      
                    sumas.push(pre);
                } 
        
                opciones.forEach(opcion => {
                    var tipoOpcion = opcion.dataset.priceType;
                    var costeOpcion = parseFloat(opcion.dataset.priceAmount);
        
                    if (opcion.checked) {
                        if (tipoOpcion == 'percentage_inc') {
                            var i = 0;
                            datos.forEach(dato => {
                                var calc = dato.precio * costeOpcion / 100; // Realiza el cálculo basado en el porcentaje
            
                                // este condicional realiza las sumas correspondientes 
                                // a cada elemento del array cada vez que se hace click
                                // sin este condicional, al hacer click se concatenan los elementos del array
                                // y la suma de la tabla final sería el resultado de sumar en cada click
                                // los 4 primeros elementos del array indefinidamente
            
                                if (calculo[i]) { // Si ya hay un valor en la posición actual de la matriz
                                    calculo[i] += calc; // Suma el cálculo al valor existente
                                } else { // Si no hay un valor en la posición actual
                                    calculo[i] = calc; // Inicializa el valor con el cálculo
                                }
            
                                i++;
                            });
                        } else if (tipoOpcion == 'percentage_dec') {
                            var i = 0;
                            datos.forEach(dato => {
                                var calc = dato.precio * costeOpcion / 100; // Realiza el cálculo basado en el porcentaje
            
                                // este condicional realiza las sumas correspondientes 
                                // a cada elemento del array cada vez que se hace click
                                // sin este condicional, al hacer click se concatenan los elementos del array
                                // y la suma de la tabla final sería el resultado de sumar en cada click
                                // los 4 primeros elementos del array indefinidamente
            
                                if (calculo[i]) { // Si ya hay un valor en la posición actual de la matriz
                                    calculo[i] -= calc; // Suma el cálculo al valor existente
                                } else { // Si no hay un valor en la posición actual
                                    calculo[i] = calc; // Inicializa el valor con el cálculo
                                }
            
                                i--;
                            });
                        } else if (tipoOpcion == 'flat_fee' || tipoOpcion == 'no_cost') {
                            sumas.forEach(suma => {
                                suma.precio += costeOpcion; // Suma el costo fijo a cada elemento en la matriz sumas
                            });
                        }
                    }
                });
        
                calculo.forEach((calc, i) => {
                    sumas[i].precio += calc; // Suma los valores de la matriz calculo a la matriz sumas
                });
        
                var y = 0;
                datos.forEach(dato => {
                    dato.precio += sumas[y].precio;
                    y++;
                });
        
                sumas = sumas.map(suma => ({ precio: parseFloat(suma.precio).toFixed(2)}));

                // console.log(sumas);
            }
            
        
            // Verificar si se obtuvo el valor correctamente
            if (variationsDataParsed) {
                
                for (var i = 0; i < variationsDataParsed.length; i++) {
                    // dato.precio = arrDatos[i]
                    var variation = variationsDataParsed[i];
                    var objeto = Object.keys(variation.attributes)
                    var dato = {};
                    dato.nombre = variation.attributes[objeto[0]];
                    dato.precio = parseFloat(variation.display_price);
                    datos.push(dato);
                }
        
                datos = datos.map(dato => ({ precio: parseFloat(dato.precio) }));
            }
            
            // Actualizamos la tabla y los precios al hacer click
            // en cada elemento del formulario
            opciones.forEach(rad => {
                rad.addEventListener('click', () => {
                    calcularTabla()
                    actualizarPrecios()
                })
            })
            
            
            var contenedorWrapper = document.createElement('div')
            contenedorWrapper.classList.add('price__table')

            var tituloTabla = document.createElement('h2');
            tituloTabla.innerText = 'Tabla de precios';
            contenedorWrapper.appendChild(tituloTabla);

            var contenedor = document.createElement('table');
            var columnaNombre = document.createElement('tr');
            var columnaPrecio = document.createElement('tr');
            contenedor.classList.add('variations__table')
            
            function actualizarPrecios() {
                calcularTabla();
                // Limpiar contenido anterior
                contenedor.innerHTML = '';

                // Selecciona ambos select fields
                var select1 = document.querySelector('table.variations #pa_opciones-envio');
                var select2 = document.querySelector('table.variations #pa_cantidad');
                
                // var options1 = Array.from(select1.options).slice(1);
                var options1 = select1 ? Array.from(select1.options).slice(1) : null;
                var options2 = Array.from(select2.options).slice(1);

                options2.sort(function(a, b) {
                    return Number(a.value) - Number(b.value);
                });

                options2.forEach(function(option) {
                    select2.add(option);
                });

                // Crea un nuevo row para los encabezados de la tabla
                var thead = document.createElement('tr');
                // Crea una celda vacía para el comienzo del thead
                if (options1) {
                    thead.appendChild(document.createElement('th'));
                }
                // Agrega los nombres de las opciones del select2 como encabezados de columna
                options2.forEach(option => {
                    var th = document.createElement('th');
                    th.textContent = option.textContent;
                    thead.appendChild(th);
                });

                contenedor.appendChild(thead);

                var selectedTd = null;

                if (options1) {
                    // Para cada opción en select1, crea un nuevo row
                    options1.forEach(option1 => {
                        var tr = document.createElement('tr');

                        // Agrega el nombre de la opción como el encabezado del row
                        var th = document.createElement('th');
                        th.textContent = option1.textContent;
                        tr.appendChild(th);

                        // console.log('Comparando:', option1.value, '(', option1.value.length, ') con', datos[i].nombre1, '(', datos[i].nombre1.length, ')');
                        // console.log('Comparando:', option2.value, '(', option2.value.length, ') con', datos[i].nombre2, '(', datos[i].nombre2.length, ')');


                        // Agrega una celda para cada opción en select2

                        options2.forEach(option2 => {
                            var td = document.createElement('td');

                            // Almacenar los valores de las opciones en atributos de datos
                            td.dataset.option1Value = option1.value;
                            td.dataset.option2Value = option2.value;

                            // Buscar el precio para la combinación de opciones y ponerlo en la celda
                            var precio = buscarPrecio(option1.value, option2.value);
                            if (precio !== null) {
                                td.textContent = precio.toFixed(2);
                            }

                            // Agregar un controlador de eventos click al td
                            td.addEventListener('click', function(event) {
                                var target = event.target;

                                // Si el td que se hizo clic es el mismo que el td seleccionado, no hacer nada
                                if (target === selectedTd) {
                                    return;
                                }

                                // Si hay un td seleccionado previamente, quitarle la clase
                                if (selectedTd) {
                                    selectedTd.classList.remove('selected');
                                }

                                // Seleccionar las opciones apropiadas en los desplegables
                                select1.value = target.dataset.option1Value;
                                select2.value = target.dataset.option2Value;

                                // Disparar los eventos change en los desplegables para actualizar cualquier otro código que dependa de estos
                                var eventChange = new Event('change', { bubbles: true });
                                select1.dispatchEvent(eventChange);
                                select2.dispatchEvent(eventChange);

                                // Añadir la clase selected al td y actualizar la referencia al td seleccionado
                                target.classList.add('selected');
                                selectedTd = target;
                            });

                            tr.appendChild(td);
                        });



                        
                        contenedor.appendChild(tr);
                    });
                } else {
                    // Cuando options1 es null, se crea una sola fila.
                    var tr = document.createElement('tr');

                    options2.forEach(option2 => {
                        var td = document.createElement('td');

                        // Almacenar los valores de las opciones en atributos de datos
                        td.dataset.option2Value = option2.value;

                        // Buscar el precio para la combinación de opciones y ponerlo en la celda
                        var precio = buscarPrecio(option2.value);
                        if (precio !== null) {
                            td.textContent = precio.toFixed(2);
                        }

                        // Agregar un controlador de eventos click al td
                        td.addEventListener('click', function(event) {
                            var target = event.target;

                            // Si el td que se hizo clic es el mismo que el td seleccionado, no hacer nada
                            if (target === selectedTd) {
                                return;
                            }

                            // Si hay un td seleccionado previamente, quitarle la clase
                            if (selectedTd) {
                                selectedTd.classList.remove('selected');
                            }

                            // Seleccionar las opciones apropiadas en los desplegables
                            select2.value = target.dataset.option2Value;

                            // Disparar los eventos change en los desplegables para actualizar cualquier otro código que dependa de estos
                            var eventChange = new Event('change', { bubbles: true });
                            select2.dispatchEvent(eventChange);

                            // Añadir la clase selected al td y actualizar la referencia al td seleccionado
                            target.classList.add('selected');
                            selectedTd = target;
                        });

                        // Agrega el td a la fila
                        tr.appendChild(td);
                    });

                    // Agrega la fila al contenedor
                    contenedor.appendChild(tr);
                }


            }    

            function buscarPrecio(nombre1, nombre2) {
                // Dentro de buscarPrecio()
                
                for (var i = 0; i < datos.length; i++) {
                    // Si nombre2 no está definido, busque solo por nombre1
                    if (!nombre2 && datos[i].nombre1 === nombre1) {
                        return datos[i].precio;
                    }
                    
                    if (datos[i].nombre1 === nombre2 && datos[i].nombre2 === nombre1) {
                        // console.log(datos[i].precio);
                        return datos[i].precio;
                    }
                }
                return null;
            }



            actualizarPrecios()
        
            var atcContainer = document.querySelector('.woocommerce-variation-add-to-cart');
            contenedor.appendChild(columnaNombre);
            contenedor.appendChild(columnaPrecio);
        
            contenedorWrapper.appendChild(contenedor);
            atcContainer.appendChild(contenedorWrapper);

        

        // Selecciona el elemento con id pa_cantidad
        var cantidadElement = document.querySelector('#pa_cantidad');
        var parentTr = cantidadElement.closest('tr');
        if (parentTr) {
            parentTr.classList.add('cantidad');
        }

        // Selecciona el elemento con id pa_opciones-envio
        var cantidadElement = document.querySelector('#pa_opciones-envio');
        var parentTr = cantidadElement.closest('tr');
        if (parentTr) {
            parentTr.classList.add('envio');
        }
}
    }) */

</script>

<?php
}
