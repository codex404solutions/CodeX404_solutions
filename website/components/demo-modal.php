<?php
declare(strict_types=1);
?>
<!-- ==========================================================================
     INTERACTIVE LIVE DEMO MODAL SYSTEM
     Eye-Catching, Modern Architecture & Systems Simulator
     ========================================================================== -->
<div class="demo-modal-overlay" id="projectDemoModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="demoModalTitle">
    <div class="demo-modal-container">
        <!-- Modal Top Bar (macOS Chrome Window Header) -->
        <div class="demo-modal-header">
            <div class="demo-header-left">
                <div class="demo-window-controls" aria-hidden="true">
                    <span class="demo-window-dot dot-close"></span>
                    <span class="demo-window-dot dot-min"></span>
                    <span class="demo-window-dot dot-expand"></span>
                </div>
                <div class="demo-header-meta">
                    <div class="demo-header-title-row">
                        <span class="demo-header-icon" aria-hidden="true">⚡</span>
                        <h2 id="demoModalTitle" class="demo-header-title">CodeX404 Systems Sandbox</h2>
                        <span class="demo-header-env-badge">SIMULATED PRODUCTION RUNTIME</span>
                    </div>
                    <div class="demo-header-sub">Test interactive software architectures, ERP engines, and automated workflows.</div>
                </div>
            </div>
            <button type="button" class="demo-close-btn" aria-label="Close demo simulator" title="Close (Esc)">&times;</button>
        </div>

        <!-- Category Demo Switcher Tabs -->
        <div class="demo-modal-tabs-bar" role="tablist" aria-label="Demo Simulators">
            <button type="button" class="demo-nav-tab active" data-demo-target="erp" role="tab" aria-selected="true">
                <span class="tab-icon">🏫</span>
                <span class="tab-label">School &amp; Campus ERP</span>
                <span class="tab-indicator"></span>
            </button>
            <button type="button" class="demo-nav-tab" data-demo-target="booking" role="tab" aria-selected="false">
                <span class="tab-icon">🏥</span>
                <span class="tab-label">Clinical Healthcare Booking</span>
                <span class="tab-indicator"></span>
            </button>
            <button type="button" class="demo-nav-tab" data-demo-target="b2b" role="tab" aria-selected="false">
                <span class="tab-icon">🏎️</span>
                <span class="tab-label">Automotive Fitment &amp; Catalog</span>
                <span class="tab-indicator"></span>
            </button>
            <button type="button" class="demo-nav-tab" data-demo-target="rag" role="tab" aria-selected="false">
                <span class="tab-icon">🤖</span>
                <span class="tab-label">Enterprise AI RAG Assistant</span>
                <span class="tab-indicator"></span>
            </button>
            <button type="button" class="demo-nav-tab" data-demo-target="wa" role="tab" aria-selected="false">
                <span class="tab-icon">💬</span>
                <span class="tab-label">WhatsApp CRM &amp; Webhook</span>
                <span class="tab-indicator"></span>
            </button>
        </div>

        <!-- Modal Body (Simulator Panes) -->
        <div class="demo-modal-body">
            
            <!-- ==============================================================
                 PANE 1: SCHOOL & CAMPUS ERP (demo_key = 'erp')
                 ============================================================== -->
            <div class="demo-simulator-pane active" id="demo-pane-erp" role="tabpanel">
                <div class="demo-pane-intro">
                    <div class="demo-pane-badge">ERP Simulation</div>
                    <h3>Campus Administration &amp; Fee Ledger</h3>
                    <p>Interactive student accounts and instant fee voucher slip generation.</p>
                </div>

                <div class="demo-grid-two-col">
                    <!-- Left: Interactive Student & Fee Form -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">🎓</span>
                            <h4>Student Ledger &amp; Fee Parameters</h4>
                        </div>

                        <div class="demo-form-group">
                            <label for="erpStudentSelect">Select Active Student Profile:</label>
                            <select id="erpStudentSelect" class="demo-input-select">
                                <option value="aarav" data-id="IDC-2026-084" data-name="Aarav Sharma" data-grade="Grade 11 — Physics &amp; CS" data-tuition="12000" data-lab="3500" data-exam="1500">Aarav Sharma (IDC-2026-084 — Gr 11 Science)</option>
                                <option value="fatima" data-id="APS-2026-112" data-name="Fatima Khan" data-grade="Grade 10 — High School Tech" data-tuition="9500" data-lab="2000" data-exam="1500">Fatima Khan (APS-2026-112 — Gr 10 Tech)</option>
                                <option value="rohit" data-id="IDC-2026-241" data-name="Rohit Sen" data-grade="Grade 12 — Commerce &amp; Math" data-tuition="11000" data-lab="1500" data-exam="1500">Rohit Sen (IDC-2026-241 — Gr 12 Commerce)</option>
                            </select>
                        </div>

                        <div class="demo-fee-breakdown-inputs">
                            <div class="fee-input-row">
                                <span>Tuition Fee:</span>
                                <strong id="erpTuitionDisplay">₹12,000</strong>
                            </div>
                            <div class="fee-input-row">
                                <span>Laboratory / Library Charges:</span>
                                <strong id="erpLabDisplay">₹3,500</strong>
                            </div>
                            <div class="fee-input-row">
                                <span>Quarterly Examination Fee:</span>
                                <strong id="erpExamDisplay">₹1,500</strong>
                            </div>
                            <div class="fee-input-row erp-total-row">
                                <span>Net Quarterly Due:</span>
                                <span class="erp-total-due" id="erpTotalDue">₹17,000</span>
                            </div>
                        </div>

                        <div class="demo-action-row">
                            <button type="button" id="erpGenerateVoucherBtn" class="btn btn-primary demo-glow-btn">
                                <span>⚡ Generate Official Fee Slip</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Dynamic Generated Voucher Preview -->
                    <div class="demo-card-box demo-voucher-display-box">
                        <div class="demo-box-header">
                            <span class="box-icon">📄</span>
                            <h4>Real-Time Generated Fee Voucher</h4>
                            <span class="live-tag-pill">PDO Prepared</span>
                        </div>

                        <div class="erp-voucher-sheet" id="erpVoucherSheet">
                            <div class="voucher-watermark">CONFIDENTIAL</div>
                            <div class="voucher-top-bar">
                                <div class="voucher-inst-logo">🏛️</div>
                                <div>
                                    <div class="voucher-inst-name">INSAN DEGREE COLLEGE &amp; CAMPUS</div>
                                    <div class="voucher-inst-sub">Office of the Bursar &bull; Student Accounts Division</div>
                                </div>
                            </div>

                            <div class="voucher-details-grid">
                                <div>
                                    <span class="v-lbl">Student Name:</span>
                                    <strong class="v-val" id="vStudentName">Aarav Sharma</strong>
                                </div>
                                <div>
                                    <span class="v-lbl">Enrollment ID:</span>
                                    <strong class="v-val font-mono" id="vStudentId">IDC-2026-084</strong>
                                </div>
                                <div>
                                    <span class="v-lbl">Academic Stream:</span>
                                    <strong class="v-val" id="vStudentGrade">Grade 11 — Physics &amp; CS</strong>
                                </div>
                                <div>
                                    <span class="v-lbl">Voucher Token:</span>
                                    <strong class="v-val font-mono" id="vToken">#VCH-984210</strong>
                                </div>
                            </div>

                            <div class="voucher-table">
                                <div class="vt-row vt-head">
                                    <span>Fee Item Description</span>
                                    <span>Amount (INR)</span>
                                </div>
                                <div class="vt-row">
                                    <span>Academic Tuition Fee</span>
                                    <span id="vRowTuition">₹12,000.00</span>
                                </div>
                                <div class="vt-row">
                                    <span>Computer Lab &amp; Research Access</span>
                                    <span id="vRowLab">₹3,500.00</span>
                                </div>
                                <div class="vt-row">
                                    <span>Examination &amp; Continuous Assessment</span>
                                    <span id="vRowExam">₹1,500.00</span>
                                </div>
                                <div class="vt-row vt-total">
                                    <strong>Total Payable:</strong>
                                    <strong class="text-cyan font-mono" id="vRowTotal">₹17,000.00</strong>
                                </div>
                            </div>

                            <div class="voucher-footer">
                                <div class="voucher-barcode font-mono">||||| | |||| ||| |||||| | ||||| |||</div>
                                <div class="voucher-stamp">
                                    <div class="stamp-circle">VERIFIED &bull; CODE404</div>
                                </div>
                            </div>
                        </div>

                        <div class="voucher-action-bar">
                            <button type="button" id="erpDownloadVoucherBtn" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <span>📥 Simulate PDF Export / Print</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================================
                 PANE 2: HEALTHCARE & CLINICAL BOOKING (demo_key = 'booking' or 'healthcare')
                 ============================================================== -->
            <div class="demo-simulator-pane" id="demo-pane-booking" role="tabpanel">
                <div class="demo-pane-intro">
                    <div class="demo-pane-badge">Healthcare Simulation</div>
                    <h3>Clinical OPD &amp; Atomic Slot Lock</h3>
                    <p>Interactive specialist scheduling with concurrency collision guards.</p>
                </div>

                <div class="demo-grid-two-col">
                    <!-- Doctor Selection & Slot Picker -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">👨‍⚕️</span>
                            <h4>1. Select Specialist &amp; Date</h4>
                        </div>

                        <div class="doctor-select-list">
                            <div class="doctor-card active" data-doctor="Dr. Aris Thorne" data-dept="Senior Cardiologist" data-room="OPD Suite 402" data-fee="₹800">
                                <div class="doc-avatar">🩺</div>
                                <div class="doc-info">
                                    <strong>Dr. Aris Thorne</strong>
                                    <span>Senior Cardiologist &bull; OPD Suite 402</span>
                                </div>
                                <span class="doc-fee font-mono">₹800</span>
                            </div>

                            <div class="doctor-card" data-doctor="Dr. Meera Rao" data-dept="Chief Neurologist" data-room="OPD Suite 205" data-fee="₹1,000">
                                <div class="doc-avatar">🧠</div>
                                <div class="doc-info">
                                    <strong>Dr. Meera Rao</strong>
                                    <span>Chief Neurologist &bull; OPD Suite 205</span>
                                </div>
                                <span class="doc-fee font-mono">₹1,000</span>
                            </div>

                            <div class="doctor-card" data-doctor="Dr. Sarah Jenkins" data-dept="Lead Pediatrician" data-room="OPD Suite 108" data-fee="₹700">
                                <div class="doc-avatar">👶</div>
                                <div class="doc-info">
                                    <strong>Dr. Sarah Jenkins</strong>
                                    <span>Lead Pediatrician &bull; OPD Suite 108</span>
                                </div>
                                <span class="doc-fee font-mono">₹700</span>
                            </div>
                        </div>

                        <div style="margin-top: 1.25rem;">
                            <label style="font-size: 0.8rem; font-weight: 700; color: #FFFFFF; display: block; margin-bottom: 0.5rem;">
                                Select Available OPD Slot (Atomic Lock Demo):
                            </label>
                            <div class="slot-picker-grid" id="slotPickerGrid">
                                <button type="button" class="slot-btn" data-slot="09:30 AM">09:30 AM</button>
                                <button type="button" class="slot-btn disabled" disabled title="Already booked by another patient">10:15 AM (Booked)</button>
                                <button type="button" class="slot-btn active" data-slot="11:00 AM">11:00 AM</button>
                                <button type="button" class="slot-btn" data-slot="02:30 PM">02:30 PM</button>
                                <button type="button" class="slot-btn" data-slot="04:15 PM">04:15 PM</button>
                            </div>
                        </div>

                        <div class="demo-form-group" style="margin-top: 1rem;">
                            <label for="medPatientName">Patient Full Name:</label>
                            <input type="text" id="medPatientName" class="demo-input-text" value="Priya Deshmukh">
                        </div>

                        <div class="demo-form-group">
                            <label for="medPatientPhone">WhatsApp Number (for instant ticket):</label>
                            <input type="text" id="medPatientPhone" class="demo-input-text" value="+91 98201-44021">
                        </div>

                        <button type="button" id="medConfirmBookingBtn" class="btn btn-primary demo-glow-btn" style="width: 100%;">
                            <span>⚡ Lock Slot &amp; Issue OPD Token</span>
                        </button>
                    </div>

                    <!-- Right: Live Token & Confirmation Feed -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">🎫</span>
                            <h4>Confirmed OPD Appointment Pass</h4>
                            <span class="live-tag-pill green">Zero Collision</span>
                        </div>

                        <div class="med-pass-card" id="medPassCard">
                            <div class="med-pass-top">
                                <div>
                                    <div class="med-clinic-title">CENTRAL MEDICAL CLINICAL OPD</div>
                                    <div class="med-clinic-sub">Atomic Concurrency Controlled Reservation Engine</div>
                                </div>
                                <div class="med-token-num" id="medTokenNum">#OPD-104</div>
                            </div>

                            <div class="med-pass-body">
                                <div class="med-pass-row">
                                    <span>Consulting Doctor:</span>
                                    <strong id="medPassDoctor">Dr. Aris Thorne (Cardiology)</strong>
                                </div>
                                <div class="med-pass-row">
                                    <span>Consultation Slot:</span>
                                    <strong class="text-cyan font-mono" id="medPassSlot">Today &bull; 11:00 AM</strong>
                                </div>
                                <div class="med-pass-row">
                                    <span>Patient Name:</span>
                                    <strong id="medPassPatient">Priya Deshmukh</strong>
                                </div>
                                <div class="med-pass-row">
                                    <span>Room / Clinic Suite:</span>
                                    <span id="medPassRoom">OPD Suite 402</span>
                                </div>
                                <div class="med-pass-row">
                                    <span>Consultation Fee:</span>
                                    <strong class="text-emerald font-mono" id="medPassFee">₹800 (Paid at Counter)</strong>
                                </div>
                            </div>

                            <div class="med-pass-status">
                                <div class="status-badge-verified">
                                    <span class="dot"></span>
                                    <span>DATABASE ROW-LOCK VERIFIED</span>
                                </div>
                                <div class="med-sms-sim">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Automated WhatsApp reminder queued for <strong id="medPassPhone">+91 98201-44021</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================================
                 PANE 3: AUTOMOTIVE FITMENT & CATALOG (demo_key = 'b2b')
                 ============================================================== -->
            <div class="demo-simulator-pane" id="demo-pane-b2b" role="tabpanel">
                <div class="demo-pane-intro">
                    <div class="demo-pane-badge">Automotive Simulation</div>
                    <h3>Vehicle Fitment &amp; Compatibility</h3>
                    <p>Dynamic Year/Make/Model bolt pattern and offset matching.</p>
                </div>

                <div class="demo-grid-two-col">
                    <!-- Left: Vehicle Fitment Selector -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">🏎️</span>
                            <h4>Vehicle Specification Selector</h4>
                        </div>

                        <div class="demo-form-group">
                            <label for="fitYear">Manufacturing Year:</label>
                            <select id="fitYear" class="demo-input-select">
                                <option value="2025" selected>2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>

                        <div class="demo-form-group">
                            <label for="fitMake">Vehicle Brand / Make:</label>
                            <select id="fitMake" class="demo-input-select">
                                <option value="bmw" selected>BMW Performance</option>
                                <option value="porsche">Porsche Motorsport</option>
                                <option value="audi">Audi Sport</option>
                                <option value="mercedes">Mercedes-AMG</option>
                            </select>
                        </div>

                        <div class="demo-form-group">
                            <label for="fitModel">Vehicle Chassis / Model:</label>
                            <select id="fitModel" class="demo-input-select">
                                <option value="m4" data-bolt="5x112" data-cb="66.6 mm" data-offset="ET20 / ET25" data-spec="Front: 19x9.5 | Rear: 20x10.5">M4 Competition (G82 Chassis)</option>
                                <option value="m3" data-bolt="5x112" data-cb="66.6 mm" data-offset="ET20 / ET25" data-spec="Front: 19x9.5 | Rear: 20x10.5">M3 Sedan (G80 Chassis)</option>
                                <option value="m2" data-bolt="5x112" data-cb="66.6 mm" data-offset="ET20 / ET20" data-spec="Front: 19x9.5 | Rear: 20x10.0">M2 Coupe (G87 Chassis)</option>
                            </select>
                        </div>

                        <div class="fitment-specs-pill-card">
                            <div class="spec-col">
                                <span class="spec-lbl">PCD Bolt Pattern</span>
                                <strong class="spec-val font-mono" id="fitBolt">5x112</strong>
                            </div>
                            <div class="spec-col">
                                <span class="spec-lbl">Center Bore</span>
                                <strong class="spec-val font-mono" id="fitCb">66.6 mm</strong>
                            </div>
                            <div class="spec-col">
                                <span class="spec-lbl">Safe Offset</span>
                                <strong class="spec-val font-mono" id="fitOffset">ET20 / ET25</strong>
                            </div>
                        </div>

                        <button type="button" id="fitQueryBtn" class="btn btn-primary demo-glow-btn" style="width: 100%; margin-top: 1rem;">
                            <span>⚡ Query Live Compatibility Matrix</span>
                        </button>
                    </div>

                    <!-- Right: Verified Fitment Wheels -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">⚙️</span>
                            <h4>Verified Compatible Forged Wheels</h4>
                            <span class="live-tag-pill green">100% Fit Guaranteed</span>
                        </div>

                        <div class="fit-results-list" id="fitResultsList">
                            <div class="wheel-result-card">
                                <div class="wheel-icon">🛞</div>
                                <div class="wheel-info">
                                    <strong>ApexForged Apex-GT 2-Piece Monoblock</strong>
                                    <div class="wheel-sub font-mono">Front: 19x9.5 ET20 &bull; Rear: 20x10.5 ET25</div>
                                    <div class="wheel-tags">
                                        <span class="w-tag">TUV Certified</span>
                                        <span class="w-tag">Aviation Alloy</span>
                                        <span class="w-tag green">In Stock (4 Sets)</span>
                                    </div>
                                </div>
                                <div class="wheel-pricing">
                                    <span class="price-val font-mono">₹1,85,000</span>
                                    <span class="price-unit">per set of 4</span>
                                </div>
                            </div>

                            <div class="wheel-result-card">
                                <div class="wheel-icon">🛞</div>
                                <div class="wheel-info">
                                    <strong>TrackSpec Competition Lightweight RS</strong>
                                    <div class="wheel-sub font-mono">Front: 19x9.5 ET20 &bull; Rear: 20x10.5 ET25</div>
                                    <div class="wheel-tags">
                                        <span class="w-tag">8.9 kg Ultra-Light</span>
                                        <span class="w-tag">Satin Carbon Black</span>
                                        <span class="w-tag green">In Stock (2 Sets)</span>
                                    </div>
                                </div>
                                <div class="wheel-pricing">
                                    <span class="price-val font-mono">₹2,10,000</span>
                                    <span class="price-unit">per set of 4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================================
                 PANE 4: ENTERPRISE AI RAG (demo_key = 'rag')
                 ============================================================== -->
            <div class="demo-simulator-pane" id="demo-pane-rag" role="tabpanel">
                <div class="demo-pane-intro">
                    <div class="demo-pane-badge">AI Simulation</div>
                    <h3>Grounded Vector Knowledge Assistant</h3>
                    <p>Semantic vector retrieval with source citation references.</p>
                </div>

                <div class="rag-chat-interface-card">
                    <!-- Quick Prompt Chips -->
                    <div class="rag-prompt-chips-bar">
                        <span class="chips-label">Quick Prompts:</span>
                        <button type="button" class="rag-chip" data-prompt="What database and backend stack does CodeX404 use?">💻 Tech Stack Architecture?</button>
                        <button type="button" class="rag-chip" data-prompt="Explain how patient appointment double-booking is prevented.">🏥 Atomic Concurrency Lock?</button>
                        <button type="button" class="rag-chip" data-prompt="Who owns the source code and IP after completion?">📜 Intellectual Property Terms?</button>
                    </div>

                    <!-- Chat Message Stream -->
                    <div class="rag-chat-stream" id="ragChatBox">
                        <div class="rag-message-row ai">
                            <div class="rag-avatar">🤖</div>
                            <div class="rag-msg-bubble">
                                <div class="rag-msg-meta">CodeX404 Grounded RAG Agent &bull; Isolated Context</div>
                                <p>Welcome to the CodeX404 Architecture Demonstrator. Ask any question regarding our software engineering standards, relational schemas, or deployment pipelines.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Bar -->
                    <div class="rag-input-bar">
                        <input type="text" id="ragInput" placeholder="Ask a technical or architectural question..." autocomplete="off">
                        <button type="button" id="ragSendBtn" class="btn btn-primary btn-sm">
                            <span>Ask Agent &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ==============================================================
                 PANE 5: WHATSAPP CRM AUTOMATION (demo_key = 'wa')
                 ============================================================== -->
            <div class="demo-simulator-pane" id="demo-pane-wa" role="tabpanel">
                <div class="demo-pane-intro">
                    <div class="demo-pane-badge">Automation Simulation</div>
                    <h3>WhatsApp Lead Ingestion &amp; Webhook</h3>
                    <p>Simulated customer messaging with live synchronous webhook telemetry.</p>
                </div>

                <div class="demo-grid-two-col">
                    <!-- Left: Smartphone WhatsApp Frame -->
                    <div class="phone-simulator-frame">
                        <div class="phone-notch">
                            <span class="phone-speaker"></span>
                            <span class="phone-camera"></span>
                        </div>

                        <div class="wa-header">
                            <div class="wa-avatar">404</div>
                            <div class="wa-contact-info">
                                <strong>CodeX404 Solutions</strong>
                                <span class="wa-verified">✓ Official Business Account</span>
                            </div>
                        </div>

                        <div class="wa-chat-canvas" id="waChatLog">
                            <div class="wa-msg inbound">
                                <p>Hi CodeX404, we are planning a custom B2B wholesale platform for 100+ dealers. Can we discuss technical feasibility?</p>
                                <span class="wa-time">10:42 AM</span>
                            </div>
                            <div class="wa-msg outbound">
                                <p>👋 Hello! Thank you for reaching out to CodeX404 Solutions. We specialize in B2B commerce and custom enterprise platforms.</p>
                                <p style="margin-top: 4px;">Our solutions architect has received your inquiry. Reference Ticket: <strong>#CX-8842</strong>.</p>
                                <span class="wa-time">10:42 AM &bull; ✓✓</span>
                            </div>
                        </div>

                        <div class="wa-action-bar">
                            <button type="button" id="waSimulateBtn" class="btn btn-primary btn-sm" style="width: 100%;">
                                <span>⚡ Trigger Next Simulated Message</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Real-Time Webhook JSON Payload -->
                    <div class="demo-card-box">
                        <div class="demo-box-header">
                            <span class="box-icon">⚡</span>
                            <h4>Synchronous Webhook Ingestion Telemetry</h4>
                            <span class="live-tag-pill green">HMAC Validated</span>
                        </div>

                        <div class="webhook-telemetry-feed" id="crmLeadList">
                            <div class="webhook-payload-item">
                                <div class="wp-top">
                                    <span class="wp-endpoint">POST /api/webhooks/whatsapp/inbound</span>
                                    <span class="wp-status font-mono">200 OK &bull; 18ms</span>
                                </div>
                                <pre class="wp-code font-mono"><code>{
  "event": "messages.received",
  "ticket_id": "CX-8842",
  "sender": {
    "phone": "+91 98201-XXXXX",
    "channel": "WhatsApp Cloud API"
  },
  "intent": "b2b_wholesale_inquiry",
  "crm_status": "LEAD_INGESTED",
  "routing": "Enterprise Architecture Desk",
  "timestamp": "2026-11-19T07:54:16Z"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
