@if(route_is('research.index'))
    <script>
        introJs().setOptions({
            steps:[
                {
                    title: 'Nouvelle cartouche de recherche',
                    element: document.querySelector('.tree'),
                    intro: "De nouvelle zones de recherches ont été ajouté"
                }
            ],
            dontShowAgain: true
        }).start()
    </script>
@endif

@if(route_is('research.infrastructure'))
    <script>
        introJs().setOptions({
            steps:[
                {
                    title: 'Recherche sur les infrastructure',
                    intro: "La recherche structurelle vous permet d'augmenter le niveau de vos infrastructures afin de bénéficier d'avantage divers et variés suivant l'infrastructure"
                },
                {
                    title: 'Infrastructure: HUB',
                    element: document.querySelector('#hubs').querySelector('.card-body'),
                    intro: "La mise à niveau d'un Hub vous permettra d'obtenir des avantages sur le hub suivant sont niveau",
                },
                {
                    title: 'Niveau de votre hub',
                    element: document.querySelector('#hubs').querySelector('.card-body').querySelector('[data-id="level"]'),
                    intro: "Plus votre niveau sera élever, plus les statistiques de votre hub vont également augmenter"
                },
                {
                    title: 'Augmentation du niveau du hub',
                    element: document.querySelector('#hubs').querySelector('.card-body').querySelector('.card-toolbar'),
                    intro: "En cliquant ici, vous pourrez augmenter le niveau de votre hub moyennant quelque crédit bancaire"
                },
                {
                    title: "Note sur l'augmentation d'un hub",
                    element: document.querySelector('#hubs').querySelector('.card-body').querySelector('.card-toolbar'),
                    intro: "Le niveau d'un hub augmente par paliers, c'est à dire que une fois au niveau 10, il faut que le niveau de votre entreprise soit également à ce niveau pour pouvoir de nouveau augmenter le niveau de votre infrastructure."
                }
            ],
            dontShowAgain: true
        }).start()
    </script>
@endif

@if(route_is('network.hub.show'))
    <script>
        introJs().setOptions({
            steps:[
                {
                    title: 'Nouvelle onglet: Rentes',
                    element: document.querySelector('[href="#rents"]'),
                    intro: "Un nouvelle onglet à été ajouter: Rentes"
                }
            ],
            dontShowAgain: true
        }).start()

        let tabEl = document.querySelectorAll('a[data-bs-toggle="tab"]')
        tabEl.forEach(tab => {
            tab.addEventListener('shown.bs.tab', event => {

                if(event.target.getAttribute('href') === '#rents') {
                    introJs().setOptions({
                        steps:[
                            {
                                title: 'Système de Rente',
                                intro: "En plus des revenues des lignes et des rentes auxilliaires de celle-ci, chaque hub bénéficie d'espace commercial, d'emplacement publicitaire et d'un parking."
                            },
                            {
                                title: 'Système de Rente',
                                intro: "Tous les jours des revenues supplémentaires viennent s'ajouter à votre CA."
                            }
                        ],
                        dontShowAgain: true
                    }).start()
                }
            })
        })
    </script>
@endif
