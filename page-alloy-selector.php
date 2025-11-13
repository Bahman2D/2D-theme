<?php
/**
 * Template Name: انتخابگر هوشمند آلیاژ (Alloy Selector Wizard)
 * Description: انتخابگر چند مرحله‌ای برای پیدا کردن بهترین آلیاژ
 * 
 * @package D_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="site-main alloy-selector-wizard" id="main" role="main">
    
    <div class="wizard-container">
        
        <!-- Header -->
        <header class="wizard-header">
            <h1 class="wizard-title">انتخابگر هوشمند آلیاژ</h1>
            <p class="wizard-subtitle">در چند مرحله ساده، بهترین آلیاژ برای کاربرد خود را پیدا کنید</p>
        </header>
        
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-line"></div>
                <div class="progress-fill" id="progressFill"></div>
                
                <div class="step" data-step="1">
                    <div class="step-circle">۱</div>
                    <div class="step-label">کاربرد</div>
                </div>
                
                <div class="step" data-step="2">
                    <div class="step-circle">۲</div>
                    <div class="step-label">نوع بار</div>
                </div>
                
                <div class="step" data-step="3">
                    <div class="step-circle">۳</div>
                    <div class="step-label">شرایط محیطی</div>
                </div>
                
                <div class="step" data-step="4">
                    <div class="step-circle">۴</div>
                    <div class="step-label">الزامات خاص</div>
                </div>
                
                <div class="step" data-step="5">
                    <div class="step-circle">✓</div>
                    <div class="step-label">نتایج</div>
                </div>
            </div>
        </div>
        
        <!-- Form Card -->
        <div class="wizard-card" id="wizardCard">
            
            <form id="selectorForm">
                
                <!-- Step 1: Application Type -->
                <div class="wizard-section active" data-section="1">
                    <h2>قطعه شما برای چه کاربردی است؟</h2>
                    <p class="section-subtitle">کاربرد اصلی قطعه را انتخاب کنید</p>
                    
                    <div class="options-grid">
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="bearing" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">⚙️</div>
                                <strong>بلبرینگ</strong>
                                <p>بلبرینگ‌های غلتشی و گلوله‌ای</p>
                            </div>
                        </label>
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="spring" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">🔄</div>
                                <strong>فنر</strong>
                                <p>فنرهای صنعتی و خودرو</p>
                            </div>
                        </label>
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="gear" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">⚡</div>
                                <strong>چرخ دنده</strong>
                                <p>گیربکس و قطعات انتقال قدرت</p>
                            </div>
                        </label>
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="shaft" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">🔩</div>
                                <strong>شفت و محور</strong>
                                <p>محورهای چرخشی و انتقال نیرو</p>
                            </div>
                        </label>
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="tool" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">🔨</div>
                                <strong>ابزار و قالب</strong>
                                <p>قالب‌های تزریق، برش و پرس</p>
                            </div>
                        </label>
                        
                        <label class="option-card">
                            <input type="radio" name="application" value="structural" required>
                            <span class="checkmark">✓</span>
                            <div class="option-content">
                                <div class="option-icon">🏗️</div>
                                <strong>سازه‌ای</strong>
                                <p>قطعات سازه و پیچ و مهره</p>
                            </div>
                        </label>
                        
                    </div>
                </div>
                
                <!-- Step 2: Load Type -->
                <div class="wizard-section" data-section="2">
                    <h2>قطعه شما تحت چه نوع باری است؟</h2>
                    <p class="section-subtitle">نوع بار و شرایط مکانیکی را مشخص کنید</p>
                    
                    <div class="form-group">
                        <label>نوع بار <span class="required">*</span></label>
                        <div class="options-grid">
                            
                            <label class="option-card">
                                <input type="radio" name="load_type" value="static" required>
                                <span class="checkmark">✓</span>
                                <div class="option-content">
                                    <div class="option-icon">⬇️</div>
                                    <strong>بار ثابت</strong>
                                    <p>فشار یا کشش ثابت</p>
                                </div>
                            </label>
                            
                            <label class="option-card">
                                <input type="radio" name="load_type" value="dynamic" required>
                                <span class="checkmark">✓</span>
                                <div class="option-content">
                                    <div class="option-icon">🔄</div>
                                    <strong>بار دینامیک</strong>
                                    <p>چرخش یا حرکت مداوم</p>
                                </div>
                            </label>
                            
                            <label class="option-card">
                                <input type="radio" name="load_type" value="cyclic" required>
                                <span class="checkmark">✓</span>
                                <div class="option-content">
                                    <div class="option-icon">〰️</div>
                                    <strong>بار سیکلی</strong>
                                    <p>بارگذاری تکرارشونده</p>
                                </div>
                            </label>
                            
                            <label class="option-card">
                                <input type="radio" name="load_type" value="impact" required>
                                <span class="checkmark">✓</span>
                                <div class="option-content">
                                    <div class="option-icon">💥</div>
                                    <strong>بار ضربه‌ای</strong>
                                    <p>ضربه و شوک مکانیکی</p>
                                </div>
                            </label>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="strengthLevel">سطح استحکام مورد نیاز</label>
                        <input 
                            type="range" 
                            id="strengthLevel" 
                            name="strength_level" 
                            min="1" 
                            max="5" 
                            value="3"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span>خیلی کم</span>
                            <span id="strengthValue">متوسط</span>
                            <span>خیلی زیاد</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hardnessLevel">سطح سختی مورد نیاز (HRC)</label>
                        <input 
                            type="range" 
                            id="hardnessLevel" 
                            name="hardness_level" 
                            min="20" 
                            max="65" 
                            value="40" 
                            step="5"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span>۲۰</span>
                            <span id="hardnessValue">۴۰ HRC</span>
                            <span>۶۵</span>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Environmental Conditions -->
                <div class="wizard-section" data-section="3">
                    <h2>شرایط محیطی کاربرد چگونه است؟</h2>
                    <p class="section-subtitle">دما و شرایط محیط کار را مشخص کنید</p>
                    
                    <div class="form-group">
                        <label for="temperature">دمای محیط کار <span class="required">*</span></label>
                        <select id="temperature" name="temperature" required class="form-select">
                            <option value="">انتخاب کنید...</option>
                            <option value="cryogenic">زیر صفر (کرایوژنیک)</option>
                            <option value="ambient">دمای محیط (۲۰-۵۰°C)</option>
                            <option value="elevated">دمای بالا (۵۰-۲۰۰°C)</option>
                            <option value="high">دمای خیلی بالا (۲۰۰-۴۰۰°C)</option>
                            <option value="extreme">دمای شدید (۴۰۰°C+)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="environment">محیط کاری <span class="required">*</span></label>
                        <select id="environment" name="environment" required class="form-select">
                            <option value="">انتخاب کنید...</option>
                            <option value="indoor">داخل سالن (خشک)</option>
                            <option value="outdoor">فضای باز</option>
                            <option value="humid">محیط مرطوب</option>
                            <option value="corrosive">محیط خورنده (اسید/نمک)</option>
                            <option value="chemical">محیط شیمیایی</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>نیاز به مقاومت در برابر:</label>
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="resistance[]" value="wear">
                                <span>سایش شدید</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="resistance[]" value="corrosion">
                                <span>خوردگی</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="resistance[]" value="oxidation">
                                <span>اکسیداسیون</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="resistance[]" value="creep">
                                <span>خزش (Creep)</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4: Special Requirements -->
                <div class="wizard-section" data-section="4">
                    <h2>الزامات خاص</h2>
                    <p class="section-subtitle">ویژگی‌های تولید و محدودیت‌ها</p>
                    
                    <div class="form-group">
                        <label for="machinability">اهمیت ماشین‌کاری</label>
                        <select id="machinability" name="machinability" class="form-select">
                            <option value="">مهم نیست</option>
                            <option value="high">بسیار مهم (ماشین‌کاری زیاد)</option>
                            <option value="medium">متوسط</option>
                            <option value="low">کم (عملیات حرارتی اصلی است)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="weldability">نیاز به جوش‌کاری</label>
                        <select id="weldability" name="weldability" class="form-select">
                            <option value="">خیر</option>
                            <option value="yes">بله، قابلیت جوش مهم است</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="section_size">سایز قطعه (ضخامت/قطر)</label>
                        <select id="section_size" name="section_size" class="form-select">
                            <option value="small">کوچک (< ۲۵mm)</option>
                            <option value="medium">متوسط (۲۵-۷۵mm)</option>
                            <option value="large">بزرگ (> ۷۵mm)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="cost_priority">اولویت هزینه</label>
                        <select id="cost_priority" name="cost_priority" class="form-select">
                            <option value="low">کیفیت مهمتر از قیمت است</option>
                            <option value="medium">تعادل بین کیفیت و قیمت</option>
                            <option value="high">قیمت اقتصادی مهم است</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="additional_notes">توضیحات تکمیلی (اختیاری)</label>
                        <textarea 
                            id="additional_notes" 
                            name="additional_notes" 
                            rows="3" 
                            class="form-textarea"
                            placeholder="اطلاعات اضافی در مورد کاربرد یا شرایط خاص..."
                        ></textarea>
                    </div>
                </div>
                
            </form>
            
            <!-- Navigation Buttons -->
            <div class="wizard-actions">
                <button type="button" id="prevBtn" class="btn btn-secondary" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                    بازگشت
                </button>
                <button type="button" id="nextBtn" class="btn btn-primary">
                    بعدی 
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 6l1.41 1.41L10.83 12l4.58 4.59L14 18l-6-6z"/></svg>
                </button>
            </div>
        </div>
        
        <!-- Results Section (Hidden initially) -->
        <div class="wizard-results" id="wizardResults" style="display: none;">
            
            <div class="results-header">
                <h2>نتایج انتخابگر</h2>
                <p>بر اساس نیازهای شما، این آلیاژها پیشنهاد می‌شوند:</p>
            </div>
            
            <div id="resultsContainer">
                <!-- Results will be populated by JavaScript -->
            </div>
            
            <div class="results-footer">
                <div class="cta-box">
                    <div class="cta-icon">📞</div>
                    <div class="cta-content">
                        <strong>نیاز به مشاوره تخصصی دارید؟</strong>
                        <p>تیم فنی فولاد اقبالی آماده ارائه مشاوره رایگان است</p>
                        <a href="tel:02133333333" class="btn btn-white">تماس با کارشناس: ۰۲۱-۳۳۳۳۳۳۳۳</a>
                    </div>
                </div>
                
                <div class="results-actions">
                    <button type="button" id="resetBtn" class="btn btn-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
                        انتخاب مجدد
                    </button>
                </div>
            </div>
            
        </div>
        
        <!-- Info Box -->
        <div class="info-box">
            <div class="info-icon">💡</div>
            <div class="info-content">
                <strong>راهنما:</strong> پاسخ‌های دقیق‌تر منجر به پیشنهادات بهتر می‌شود. در صورت نیاز به مشاوره، با کارشناسان ما تماس بگیرید.
            </div>
        </div>
        
    </div>
    
</main>

<?php get_footer(); ?>
