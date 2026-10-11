document.addEventListener('DOMContentLoaded', () => {
    const searchBlocks = document.querySelectorAll('.pm-advanced-search');

    searchBlocks.forEach(block => {
        const input = block.querySelector('#pm-live-search-input');
        const resultsContainer = block.querySelector('#pm-search-results');
        const noResults = block.querySelector('#pm-search-no-results');
        const spinner = block.querySelector('#pm-search-spinner');
        const apiUrl = block.getAttribute('data-api-url');
        
        let debounceTimer;

        input.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            
            clearTimeout(debounceTimer);

            if (query.length < 2) {
                resultsContainer.innerHTML = '';
                noResults.classList.add('hidden');
                spinner.classList.add('hidden');
                return;
            }

            spinner.classList.remove('hidden');

            debounceTimer = setTimeout(() => {
                fetch(`${apiUrl}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        spinner.classList.add('hidden');
                        resultsContainer.innerHTML = '';
                        
                        if (data.length === 0) {
                            noResults.classList.remove('hidden');
                        } else {
                            noResults.classList.add('hidden');
                            
                            data.forEach(item => {
                                const card = document.createElement('a');
                                card.href = item.url;
                                card.className = 'group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col h-full';
                                
                                let imageHtml = '';
                                if (item.image) {
                                    imageHtml = `<img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">`;
                                } else {
                                    imageHtml = `
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-50"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-6xl opacity-20">${item.icon}</span>
                                        </div>
                                    `;
                                }

                                card.innerHTML = `
                                    <div class="h-48 bg-gray-200 relative overflow-hidden shrink-0">
                                        ${imageHtml}
                                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow text-sm font-semibold text-amber-600 flex items-center gap-1">
                                            ${item.icon} ${item.type}
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">${item.title}</h3>
                                        <p class="text-gray-600 text-sm flex-grow line-clamp-3">${item.excerpt}</p>
                                    </div>
                                `;
                                
                                resultsContainer.appendChild(card);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        spinner.classList.add('hidden');
                    });
            }, 300); // 300ms debounce
        });
    });
});
