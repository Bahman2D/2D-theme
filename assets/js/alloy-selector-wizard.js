/**
 * Alloy Selector Wizard JavaScript
 * File: assets/js/alloy-selector-wizard.js
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  // Global variables
  let currentStep = 1;
  const totalSteps = 4;
  let alloyDatabase = null;
  
  // DOM Elements
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');
  const resetBtn = document.getElementById('resetBtn');
  const progressFill = document.getElementById('progressFill');
  const selectorForm = document.getElementById('selectorForm');
  const wizardCard = document.getElementById('wizardCard');
  const wizardResults = document.getElementById('wizardResults');
  const resultsContainer = document.getElementById('resultsContainer');
  
  // Range sliders
  const strengthLevel = document.getElementById('strengthLevel');
  const strengthValue = document.getElementById('strengthValue');
  const hardnessLevel = document.getElementById('hardnessLevel');
  const hardnessValue = document.getElementById('hardnessValue');
  
  const strengthLabels = ['خیلی کم', 'کم', 'متوسط', 'زیاد', 'خیلی زیاد'];
  
  /**
   * Initialize the wizard
   */
  function init() {
    // Load alloy database
    loadAlloyDatabase();
    
    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', handleNext);
    if (prevBtn) prevBtn.addEventListener('click', handlePrev);
    if (resetBtn) resetBtn.addEventListener('click', handleReset);
    
    // Range sliders
    if (strengthLevel) {
      strengthLevel.addEventListener('input', (e) => {
        if (strengthValue) {
          strengthValue.textContent = strengthLabels[parseInt(e.target.value) - 1];
        }
      });
    }
    
    if (hardnessLevel) {
      hardnessLevel.addEventListener('input', (e) => {
        if (hardnessValue) {
          const value = parseInt(e.target.value);
          hardnessValue.textContent = value + ' HRC';
        }
      });
    }
    
    // Initialize UI
    updateUI();
  }
  
  /**
   * Load alloy database from JSON
   */
  async function loadAlloyDatabase() {
    try {
      // Get database URL from localized script data
      const dbUrl = typeof alloyWizardData !== 'undefined' && alloyWizardData.databaseUrl 
        ? alloyWizardData.databaseUrl 
        : '/wp-content/themes/d-theme/assets/data/steel_alloys_database.json';
      
      const response = await fetch(dbUrl);
      if (!response.ok) {
        throw new Error('Failed to load database');
      }
      
      const data = await response.json();
      alloyDatabase = data.alloys;
      
      console.log('Alloy database loaded:', alloyDatabase.length, 'alloys');
    } catch (error) {
      console.error('Error loading alloy database:', error);
      // Fallback to empty array
      alloyDatabase = [];
    }
  }
  
  /**
   * Handle next button click
   */
  function handleNext() {
    const currentSection = document.querySelector(`[data-section="${currentStep}"]`);
    
    if (!validateSection(currentSection)) {
      alert('لطفاً تمام فیلدهای ضروری را پر کنید');
      return;
    }
    
    if (currentStep < totalSteps) {
      currentStep++;
      updateUI();
    } else {
      // Show results
      showResults();
    }
  }
  
  /**
   * Handle prev button click
   */
  function handlePrev() {
    if (currentStep > 1) {
      currentStep--;
      updateUI();
    }
  }
  
  /**
   * Handle reset button click
   */
  function handleReset() {
    currentStep = 1;
    if (selectorForm) selectorForm.reset();
    
    // Reset slider values
    if (strengthValue) strengthValue.textContent = 'متوسط';
    if (hardnessValue) hardnessValue.textContent = '۴۰ HRC';
    
    // Show form, hide results
    if (wizardCard) wizardCard.style.display = 'block';
    if (wizardResults) wizardResults.style.display = 'none';
    
    updateUI();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  
  /**
   * Validate current section
   */
  function validateSection(section) {
    if (!section) return false;
    
    const requiredInputs = section.querySelectorAll('[required]');
    let isValid = true;
    
    requiredInputs.forEach(input => {
      if (input.type === 'radio') {
        const radioGroup = section.querySelectorAll(`[name="${input.name}"]`);
        const isChecked = Array.from(radioGroup).some(r => r.checked);
        if (!isChecked) {
          isValid = false;
        }
      } else if (input.tagName === 'SELECT') {
        if (!input.value) {
          isValid = false;
          input.style.borderColor = 'var(--danger)';
        } else {
          input.style.borderColor = '';
        }
      } else if (!input.value) {
        isValid = false;
        input.style.borderColor = 'var(--danger)';
      } else {
        input.style.borderColor = '';
      }
    });
    
    return isValid;
  }
  
  /**
   * Update UI based on current step
   */
  function updateUI() {
    // Update sections
    document.querySelectorAll('.wizard-section').forEach(section => {
      section.classList.remove('active');
    });
    
    const currentSection = document.querySelector(`[data-section="${currentStep}"]`);
    if (currentSection) {
      currentSection.classList.add('active');
    }
    
    // Update progress
    const progress = (currentStep / (totalSteps + 1)) * 100;
    if (progressFill) {
      progressFill.style.width = progress + '%';
    }
    
    // Update steps
    document.querySelectorAll('.step').forEach(step => {
      const stepNum = parseInt(step.dataset.step);
      step.classList.remove('active', 'completed');
      
      if (stepNum < currentStep) {
        step.classList.add('completed');
      } else if (stepNum === currentStep) {
        step.classList.add('active');
      }
    });
    
    // Update buttons
    if (prevBtn) {
      prevBtn.style.display = currentStep > 1 ? 'inline-flex' : 'none';
    }
    
    if (nextBtn) {
      // RTL: left arrow for forward/next
      const arrowIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 6l1.41 1.41L10.83 12l4.58 4.59L14 18l-6-6z"/></svg>';
      nextBtn.innerHTML = currentStep === totalSteps ? 'مشاهده نتایج 🎯' : `بعدی ${arrowIcon}`;
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  
  /**
   * Show results page
   */
  function showResults() {
    // Hide form
    if (wizardCard) wizardCard.style.display = 'none';
    
    // Show results
    if (wizardResults) wizardResults.style.display = 'block';
    
    // Update progress to 100%
    if (progressFill) progressFill.style.width = '100%';
    
    // Update steps
    document.querySelectorAll('.step').forEach(step => {
      step.classList.remove('active');
      if (parseInt(step.dataset.step) <= totalSteps) {
        step.classList.add('completed');
      }
    });
    const finalStep = document.querySelector('[data-step="5"]');
    if (finalStep) finalStep.classList.add('active');
    
    // Get form data
    const formData = getFormData();
    
    // Match alloys
    const matches = matchAlloys(formData);
    
    // Render results
    renderResults(matches);
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  
  /**
   * Get form data
   */
  function getFormData() {
    const formData = {};
    
    // Application type
    const appInput = document.querySelector('input[name="application"]:checked');
    formData.application = appInput ? appInput.value : null;
    
    // Load type
    const loadInput = document.querySelector('input[name="load_type"]:checked');
    formData.loadType = loadInput ? loadInput.value : null;
    
    // Strength level
    formData.strengthLevel = parseInt(strengthLevel?.value || 3);
    
    // Hardness level
    formData.hardnessLevel = parseInt(hardnessLevel?.value || 40);
    
    // Temperature
    const tempSelect = document.getElementById('temperature');
    formData.temperature = tempSelect ? tempSelect.value : null;
    
    // Environment
    const envSelect = document.getElementById('environment');
    formData.environment = envSelect ? envSelect.value : null;
    
    // Resistance requirements
    const resistanceChecks = document.querySelectorAll('input[name="resistance[]"]:checked');
    formData.resistance = Array.from(resistanceChecks).map(cb => cb.value);
    
    // Machinability
    const machinabilitySelect = document.getElementById('machinability');
    formData.machinability = machinabilitySelect ? machinabilitySelect.value : null;
    
    // Weldability
    const weldabilitySelect = document.getElementById('weldability');
    formData.weldability = weldabilitySelect ? weldabilitySelect.value : null;
    
    // Section size
    const sectionSelect = document.getElementById('section_size');
    formData.sectionSize = sectionSelect ? sectionSelect.value : 'medium';
    
    // Cost priority
    const costSelect = document.getElementById('cost_priority');
    formData.costPriority = costSelect ? costSelect.value : 'medium';
    
    return formData;
  }
  
  /**
   * Match alloys based on form data
   */
  function matchAlloys(formData) {
    if (!alloyDatabase || alloyDatabase.length === 0) {
      return [];
    }
    
    const scored = alloyDatabase.map(alloy => {
      let score = 0;
      let maxScore = 0;
      const reasons = [];
      
      // Application matching (weight: 30)
      maxScore += 30;
      if (formData.application) {
        const appCategories = alloy.applications?.application_categories || [];
        if (formData.application === 'bearing' && appCategories.includes('bearing')) {
          score += 30;
          reasons.push('مناسب برای کاربردهای بلبرینگ');
        } else if (formData.application === 'spring' && appCategories.includes('spring')) {
          score += 30;
          reasons.push('طراحی شده برای فنرها');
        } else if (formData.application === 'gear' && appCategories.includes('gear')) {
          score += 30;
          reasons.push('مناسب برای چرخ دنده‌ها');
        } else if (formData.application === 'tool' && appCategories.includes('tool')) {
          score += 30;
          reasons.push('فولاد ابزار با کیفیت بالا');
        } else if (formData.application === 'shaft' && (appCategories.includes('structural') || appCategories.includes('machinery'))) {
          score += 25;
          reasons.push('مناسب برای شفت و محورها');
        } else if (formData.application === 'structural' && appCategories.includes('structural')) {
          score += 30;
          reasons.push('فولاد سازه‌ای قوی');
        } else {
          score += 10; // Partial match
        }
      }
      
      // Hardness matching (weight: 20)
      maxScore += 20;
      const hardnessMin = alloy.mechanical_properties?.hardness_hrc_min || 0;
      const hardnessMax = alloy.mechanical_properties?.hardness_hrc_max || 70;
      if (formData.hardnessLevel >= hardnessMin && formData.hardnessLevel <= hardnessMax) {
        score += 20;
        reasons.push(`سختی ${hardnessMin}-${hardnessMax} HRC`);
      } else if (Math.abs(formData.hardnessLevel - hardnessMin) <= 10 || Math.abs(formData.hardnessLevel - hardnessMax) <= 10) {
        score += 10;
      }
      
      // Temperature matching (weight: 20)
      maxScore += 20;
      if (formData.temperature) {
        const tempMin = alloy.temperature_performance?.temp_range_min || -40;
        const tempMax = alloy.temperature_performance?.temp_range_max || 400;
        
        if (formData.temperature === 'cryogenic' && alloy.temperature_performance?.cryogenic_service) {
          score += 20;
          reasons.push('مناسب برای دماهای پایین');
        } else if (formData.temperature === 'ambient' && tempMax >= 50) {
          score += 20;
        } else if (formData.temperature === 'elevated' && tempMax >= 200) {
          score += 20;
          reasons.push('مقاومت خوب در دماهای متوسط');
        } else if (formData.temperature === 'high' && tempMax >= 400) {
          score += 20;
          reasons.push('مقاومت خوب در دماهای بالا');
        } else if (formData.temperature === 'extreme' && tempMax >= 500) {
          score += 20;
          reasons.push('مقاومت عالی در دماهای شدید');
        } else {
          score += 5;
        }
      }
      
      // Wear resistance (weight: 15)
      maxScore += 15;
      if (formData.resistance.includes('wear')) {
        const wearResistance = alloy.mechanical_properties?.wear_resistance || 5;
        if (wearResistance >= 8) {
          score += 15;
          reasons.push('مقاومت سایشی عالی');
        } else if (wearResistance >= 6) {
          score += 10;
          reasons.push('مقاومت سایشی خوب');
        } else {
          score += 5;
        }
      } else {
        score += 15; // Not required
      }
      
      // Machinability (weight: 10)
      maxScore += 10;
      const machinabilityRating = alloy.manufacturing_properties?.machinability_rating || 50;
      if (formData.machinability === 'high') {
        if (machinabilityRating >= 70) {
          score += 10;
          reasons.push('ماشین‌کاری عالی');
        } else if (machinabilityRating >= 50) {
          score += 5;
        }
      } else if (formData.machinability === 'medium') {
        if (machinabilityRating >= 40) {
          score += 10;
        }
      } else {
        score += 10; // Not important
      }
      
      // Cost consideration (weight: 5)
      maxScore += 5;
      const costMultiplier = alloy.economic_data?.cost_multiplier || 2.5;
      if (formData.costPriority === 'high') {
        if (costMultiplier <= 2.5) {
          score += 5;
          reasons.push('قیمت اقتصادی');
        } else if (costMultiplier <= 3.5) {
          score += 3;
        }
      } else if (formData.costPriority === 'medium') {
        if (costMultiplier <= 3.5) {
          score += 5;
        }
      } else {
        score += 5; // Cost not important
      }
      
      // Calculate percentage
      const matchPercentage = Math.round((score / maxScore) * 100);
      
      return {
        alloy: alloy,
        score: score,
        maxScore: maxScore,
        matchPercentage: matchPercentage,
        reasons: reasons
      };
    });
    
    // Sort by score and return top 3
    scored.sort((a, b) => b.score - a.score);
    return scored.slice(0, 3);
  }
  
  /**
   * Render results
   */
  function renderResults(matches) {
    if (!resultsContainer) return;
    
    if (matches.length === 0) {
      resultsContainer.innerHTML = `
        <div class="result-card">
          <p style="text-align: center; padding: 2rem;">
            متأسفانه آلیاژ مناسبی بر اساس معیارهای شما پیدا نشد. لطفاً با کارشناسان ما تماس بگیرید.
          </p>
        </div>
      `;
      return;
    }
    
    let html = '';
    
    matches.forEach((match, index) => {
      const alloy = match.alloy;
      const percentage = match.matchPercentage;
      
      // Determine match level
      let matchClass = 'excellent';
      let matchLabel = 'عالی';
      if (percentage >= 90) {
        matchClass = 'excellent';
        matchLabel = 'مطابقت عالی';
      } else if (percentage >= 80) {
        matchClass = 'good';
        matchLabel = 'مطابقت خوب';
      } else {
        matchClass = 'fair';
        matchLabel = 'مطابقت قابل قبول';
      }
      
      // Get category URL slug
      const categorySlug = getCategorySlug(alloy.category_fa);
      const alloySlug = alloy.material_number.replace('.', '-');
      const baseUrl = typeof alloyWizardData !== 'undefined' && alloyWizardData.homeUrl 
        ? alloyWizardData.homeUrl 
        : '/';
      const alloyUrl = `${baseUrl}${categorySlug}/${alloySlug}`;
      
      // Rank label
      let rankLabel = '';
      if (index === 0) {
        rankLabel = '<strong>✓ پیشنهاد اول</strong>';
      } else if (index === 1) {
        rankLabel = '<strong>✓ گزینه جایگزین</strong>';
      } else {
        rankLabel = '<strong>✓ گزینه سوم</strong>';
      }
      
      html += `
        <div class="result-card">
          <div class="result-header">
            <div class="result-title">
              <h3>${alloy.name_fa || alloy.name_en} (${alloy.material_number})</h3>
              <p class="result-subtitle">${alloy.category_fa || alloy.category}</p>
            </div>
            <div class="match-badge ${matchClass}">${percentage}%</div>
          </div>
          
          ${alloy.standards ? `
          <div class="standards">
            ${alloy.standards.din_en ? `<span class="standard-tag">DIN: ${alloy.material_number}</span>` : ''}
            ${alloy.standards.sae_aisi ? `<span class="standard-tag">AISI: ${alloy.standards.sae_aisi}</span>` : ''}
            ${alloy.standards.iso_standard ? `<span class="standard-tag">ISO: ${alloy.standards.iso_standard}</span>` : ''}
          </div>
          ` : ''}
          
          <div class="why-section">
            ${rankLabel}
            <p>${match.reasons.join(' • ')}</p>
          </div>
          
          <div class="specs-grid">
            ${alloy.mechanical_properties ? `
              <div class="spec-item">
                <div class="spec-label">سختی</div>
                <div class="spec-value">${alloy.mechanical_properties.hardness_hrc_min || '-'}-${alloy.mechanical_properties.hardness_hrc_max || '-'} HRC</div>
              </div>
            ` : ''}
            
            ${alloy.mechanical_properties?.tensile_strength_max ? `
              <div class="spec-item">
                <div class="spec-label">استحکام</div>
                <div class="spec-value">${alloy.mechanical_properties.tensile_strength_max} MPa</div>
              </div>
            ` : ''}
            
            ${alloy.temperature_performance ? `
              <div class="spec-item">
                <div class="spec-label">دمای کاری</div>
                <div class="spec-value">${alloy.temperature_performance.temp_range_min}°C تا ${alloy.temperature_performance.temp_range_max}°C</div>
              </div>
            ` : ''}
            
            ${alloy.economic_data ? `
              <div class="spec-item">
                <div class="spec-label">موجودی</div>
                <div class="spec-value">${alloy.economic_data.availability || 'موجود'}</div>
              </div>
            ` : ''}
          </div>
          
          <div class="result-actions">
            <a href="${alloyUrl}" class="btn btn-outline-primary">مشاهده جزئیات فنی</a>
            <a href="${baseUrl}contact" class="btn btn-accent">درخواست قیمت</a>
          </div>
        </div>
      `;
    });
    
    resultsContainer.innerHTML = html;
  }
  
  /**
   * Get category URL slug
   */
  function getCategorySlug(category) {
    const categoryMap = {
      'فولاد بلبرینگ': 'bearing-steel',
      'فولاد فنر': 'spring-steel',
      'فولاد نیتریدینگ': 'nitriding-steel',
      'فولاد مقاوم حرارتی': 'heat-resistant-steel',
      'فولاد ابزار': 'tool-steel',
      'فولاد آلیاژی': 'alloy-steel'
    };
    
    return categoryMap[category] || 'other-alloys';
  }
  
  // Initialize on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
  
})();
