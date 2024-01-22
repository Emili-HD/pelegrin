window.addEventListener('DOMContentLoaded', function () {
  var header = document.querySelector('.site-header')

  let menuDesplegable = document.querySelectorAll('#categorias-menu li a')
  let bloque = document.getElementById('categorias-iconos')
  bloque.style.backgroundSize = 'cover'
  bloque.style.backgroundPosition = 'center'
  menuDesplegable.forEach((element) => {
    element.addEventListener('mouseover', function () {
      let elementString = element.innerText
      const normalizedString = elementString
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
      const outputString = normalizedString.replace(/\s+/g, '-').toLowerCase()
      const imageUrl =
        'https://hosting143140eu-cp44.wordpresstemporal.com/wp-content/themes/pelegrin/images/' +
        outputString +
        '.webp'
      bloque.style.backgroundImage = `url(${imageUrl})`
    })
  })

  function altura() {
    var headerHeight = header.offsetHeight
    // console.log(headerHeight)
  }

  altura()

  // esperamos mientras cargan gsap & ScrollTrigger
  let chck_if_gsap_loaded = setInterval(function () {
    if (
      window.gsap &&
      window.ScrollTrigger &&
      window.ScrollSmoother &&
      window.SplitText
    ) {
      gsap.set('html, body', { scrollBehavior: 'unset' })

      // registramos scrolTrigger y ScrollSmoother
      gsap.registerPlugin(
        ScrollTrigger,
        ScrollSmoother,
        SplitText,
        ScrollToPlugin,
      )

      // ... y mostramos nuestras cosillas
      mi_gsap_script()
      mi_swiper_script()
      pageHeight()
      wooGallery()

      let alto = document.querySelector('.variations_form')
      if (alto) {
        let altura = alto.offsetHeight
        document.querySelector(
          '.single-product .woocommerce-variation-add-to-cart',
        ).style.maxHeight = altura + 'px'
      }

      // clear interval
      clearInterval(chck_if_gsap_loaded)
    }
  }, 500)

  function mi_gsap_script() {
    const mm = gsap.matchMedia()

    mm.add('(min-width: 881px)', () => {
      const smoother = ScrollSmoother.create({
        smooth: false, // cuánto tiempo (en segundos) tarda en "ponerse al día" a la posición de desplazamiento nativa
        // smoothTouch: 2,
        effects: true, // busca los atributos de velocidad de datos y de retraso de datos en los elementos
        // normalizeScroll: true, // para evitar problemas comunes como ocultar/mostrar la barra de direcciones en los navegadores móviles
        ignoreMobileResize: true,
        //speed: 0.8, // velocidad de desplazamiento, por defecto es 2
      })

      ScrollTrigger.normalizeScroll(true)
    })

    mm.add('(max-width: 1024px)', () => {
      // Obtener los elementos con las clases "menu-toggle" y "menu-mobile"
      const menuToggle = document.querySelector('.menu-toggle')
      const menuMobile = document.querySelector('.menu-mobile')
      const subMenu = document.querySelector('.menu-categorias')

      // Agregar un event listener al hacer clic en el elemento "menu-toggle"
      menuToggle.addEventListener('click', function () {
        // Alternamos las class para dar visibilidad al menú
        // e inmobilizar el body mientras el menú está activo
        this.classList.toggle('active')
        menuMobile.classList.toggle('active')
        document.body.classList.toggle('mobile-menu-active')

        if (subMenu.classList.contains('active')) {
          subMenu.classList.remove('active')
        }
      })
    })

    // ScrollTrigger.normalizeScroll(true)
  }

  function mi_swiper_script() {
    const prods = document.querySelectorAll('.producto')

    var swiper = new Swiper('.swiper-categories', {
      slidesPerView: 3,
      centeredSlides: false,
      slidesPerGroupSkip: 3,
      grid: {
        rows: 2,
      },
      spaceBetween: 0,
      pagination: {
        el: '.swiper__categories-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })

    var swiper2 = new Swiper('.swiper-products', {
      slidesPerView: 1,
      centeredSlides: false,
      spaceBetween: 0,
      effect: 'creative',
      creativeEffect: {
        prev: {
          shadow: true,
          translate: ['-20%', 0, -1],
        },
        next: {
          translate: ['100%', 0, 0],
        },
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })
    swiper2.controller.control = swiper
    swiper.controller.control = swiper2
  }

  /********************************************/
  /* Calculamos el alto de la página y lo redondeamos
  a múltiples de 25vh para que cuadre con las 
  líneas divisorias */
  /********************************************/

  function pageHeight() {
    // Seleccionamos la página
    const main = document.querySelectorAll(
      '.site-main article',
      '.site-main.section',
    )

    if (main) {
      main.forEach((sec) => {
        // Guardamos una 4 parte (25vh) de la altura de la pantalla
        let multiple = window.innerHeight / 4
        // Guardamos el alto total de la página
        let totalHeight = sec.offsetHeight
        // Redondeamos el resultado al alza y lo multiplicamos por 25vh
        let rows = Math.ceil(totalHeight / multiple) * 25 + 'vh'

        // Assignamos el nuevo height a la página
        sec.style.height = rows
      })
    }
  }

  function wooGallery() {
    const pinGallery = document.querySelector(
      '.woocommerce-product-gallery__wrapper',
    )

    // console.log(pinGallery);

    if (pinGallery) {
      ScrollTrigger.create({
        trigger: '.woocommerce-product-gallery',
        pin: pinGallery,
        pinSpacing: false,
        start: 'top top',
        end: 'bottom bottom',
        // markers: true,
      })
    }
  }

  // const simpleProduct = document.querySelector('.product-type-simple form.cart')
  // if (simpleProduct) {
  //   const nodes = [...simpleProduct.children].splice(1)

  //   const wrapper = document.createElement('div')
  //   wrapper.classList.add('addtocart-wrapper')

  //   // and append all children:
  //   wrapper.append(...nodes)

  //   // and ofc add the wrapper to the container:
  //   simpleProduct.appendChild(wrapper)
  // }

  // var disabled = document.querySelectorAll('.disabled')
  // disabled.forEach((elem) => {
  //   elem.addEventListener('click', (e) => {
  //     e.preventDefault()
  //   })
  // })

  // Obtener el div vacío y los divs con la clase "divConImagen"
  var divVacio = document.querySelector('.imagenes__fondo')
  var divsConImagen = document.getElementsByClassName('slide-cat')

  // Recorrer los divs con la clase "divConImagen"
  for (var i = 0; i < divsConImagen.length; i++) {
    var div = divsConImagen[i]

    // Añadir eventos de mouseover y mouseout a cada div
    div.addEventListener('mouseover', function () {
      // Obtener la URL de la imagen del atributo data-image
      var imageUrl = this.getAttribute('data-image')
      console.log(imageUrl)
      // Cambiar la imagen de fondo del div vacío
      divVacio.style.backgroundImage = 'url(' + imageUrl + ')'
    })

    div.addEventListener('mouseout', function () {
      // Restaurar el fondo original del div vacío
      divVacio.style.backgroundImage = ''
    })
  }
})
