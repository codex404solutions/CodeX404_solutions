/**
 * CodeX404 Solutions — Premium 3D WebGL Architectural Core & Spatial Engine v2
 * Hardware-accelerated procedural WebGL with bloom pass, constellation links,
 * atmospheric fog, pulsing emissive core, cursor tilt & coverflow sync.
 * Zero external dependencies; degrades gracefully with prefers-reduced-motion.
 */

(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ==========================================================================
     1. Procedural 3D Matrix & Vector Math (Minimal, Zero-Bloat)
     ========================================================================== */
  function mat4Identity() {
    return new Float32Array([
      1, 0, 0, 0,
      0, 1, 0, 0,
      0, 0, 1, 0,
      0, 0, 0, 1
    ]);
  }

  function mat4Multiply(a, b) {
    const out = new Float32Array(16);
    for (let c = 0; c < 4; c++) {
      for (let r = 0; r < 4; r++) {
        out[c * 4 + r] =
          a[0 * 4 + r] * b[c * 4 + 0] +
          a[1 * 4 + r] * b[c * 4 + 1] +
          a[2 * 4 + r] * b[c * 4 + 2] +
          a[3 * 4 + r] * b[c * 4 + 3];
      }
    }
    return out;
  }

  function mat4Perspective(fovyRad, aspect, near, far) {
    const f = 1.0 / Math.tan(fovyRad / 2);
    const nf = 1 / (near - far);
    return new Float32Array([
      f / aspect, 0, 0, 0,
      0, f, 0, 0,
      0, 0, (far + near) * nf, -1,
      0, 0, 2 * far * near * nf, 0
    ]);
  }

  function mat4Translate(m, x, y, z) {
    const t = mat4Identity();
    t[12] = x;
    t[13] = y;
    t[14] = z;
    return mat4Multiply(m, t);
  }

  function mat4RotateX(m, rad) {
    const c = Math.cos(rad);
    const s = Math.sin(rad);
    const r = new Float32Array([
      1, 0, 0, 0,
      0, c, s, 0,
      0, -s, c, 0,
      0, 0, 0, 1
    ]);
    return mat4Multiply(m, r);
  }

  function mat4RotateY(m, rad) {
    const c = Math.cos(rad);
    const s = Math.sin(rad);
    const r = new Float32Array([
      c, 0, -s, 0,
      0, 1, 0, 0,
      s, 0, c, 0,
      0, 0, 0, 1
    ]);
    return mat4Multiply(m, r);
  }

  function mat4RotateZ(m, rad) {
    const c = Math.cos(rad);
    const s = Math.sin(rad);
    const r = new Float32Array([
      c, s, 0, 0,
      -s, c, 0, 0,
      0, 0, 1, 0,
      0, 0, 0, 1
    ]);
    return mat4Multiply(m, r);
  }

  function mat4Scale(m, sx, sy, sz) {
    const s = mat4Identity();
    s[0] = sx;
    s[5] = sy;
    s[10] = sz;
    return mat4Multiply(m, s);
  }

  /* ==========================================================================
     2. 3D Mesh Builders (Slabs, OctaCore, Machined Rings, Icosphere)
     ========================================================================== */
  function buildBoxMesh(w, h, d) {
    const hw = w * 0.5;
    const hh = h * 0.5;
    const hd = d * 0.5;
    const faces = [
      { n: [0, 0, 1], p: [[-hw, -hh, hd], [hw, -hh, hd], [hw, hh, hd], [-hw, hh, hd]] },
      { n: [0, 0, -1], p: [[hw, -hh, -hd], [-hw, -hh, -hd], [-hw, hh, -hd], [hw, hh, -hd]] },
      { n: [0, 1, 0], p: [[-hw, hh, hd], [hw, hh, hd], [hw, hh, -hd], [-hw, hh, -hd]] },
      { n: [0, -1, 0], p: [[-hw, -hh, -hd], [hw, -hh, -hd], [hw, -hh, hd], [-hw, -hh, hd]] },
      { n: [1, 0, 0], p: [[hw, -hh, hd], [hw, -hh, -hd], [hw, hh, -hd], [hw, hh, hd]] },
      { n: [-1, 0, 0], p: [[-hw, -hh, -hd], [-hw, -hh, hd], [-hw, hh, hd], [-hw, hh, -hd]] }
    ];

    const pos = [];
    const norm = [];
    const idx = [];
    let offset = 0;

    faces.forEach((f) => {
      f.p.forEach((v) => {
        pos.push(v[0], v[1], v[2]);
        norm.push(f.n[0], f.n[1], f.n[2]);
      });
      idx.push(offset, offset + 1, offset + 2, offset, offset + 2, offset + 3);
      offset += 4;
    });

    return {
      positions: new Float32Array(pos),
      normals: new Float32Array(norm),
      indices: new Uint16Array(idx)
    };
  }

  function buildTorusRingMesh(majorR, minorR, radialSeg, tubularSeg) {
    const pos = [];
    const norm = [];
    const idx = [];

    for (let j = 0; j <= radialSeg; j++) {
      const v = (j / radialSeg) * Math.PI * 2;
      const cosV = Math.cos(v);
      const sinV = Math.sin(v);

      for (let i = 0; i <= tubularSeg; i++) {
        const u = (i / tubularSeg) * Math.PI * 2;
        const cosU = Math.cos(u);
        const sinU = Math.sin(u);

        const x = (majorR + minorR * cosV) * cosU;
        const y = minorR * sinV;
        const z = (majorR + minorR * cosV) * sinU;

        const nx = cosV * cosU;
        const ny = sinV;
        const nz = cosV * sinU;

        pos.push(x, y, z);
        norm.push(nx, ny, nz);
      }
    }

    for (let j = 1; j <= radialSeg; j++) {
      for (let i = 1; i <= tubularSeg; i++) {
        const a = (tubularSeg + 1) * j + i - 1;
        const b = (tubularSeg + 1) * (j - 1) + i - 1;
        const c = (tubularSeg + 1) * (j - 1) + i;
        const d = (tubularSeg + 1) * j + i;
        idx.push(a, b, d, b, c, d);
      }
    }

    return {
      positions: new Float32Array(pos),
      normals: new Float32Array(norm),
      indices: new Uint16Array(idx)
    };
  }

  function buildOctahedronMesh(radius) {
    const raw = [
      [0, radius, 0], [radius, 0, 0], [0, 0, radius],
      [-radius, 0, 0], [0, 0, -radius], [0, -radius, 0]
    ];
    const tris = [
      [0, 2, 1], [0, 1, 4], [0, 4, 3], [0, 3, 2],
      [5, 1, 2], [5, 4, 1], [5, 3, 4], [5, 2, 3]
    ];

    const pos = [];
    const norm = [];
    const idx = [];
    let offset = 0;

    tris.forEach((t) => {
      const a = raw[t[0]];
      const b = raw[t[1]];
      const c = raw[t[2]];

      const ux = b[0] - a[0], uy = b[1] - a[1], uz = b[2] - a[2];
      const vx = c[0] - a[0], vy = c[1] - a[1], vz = c[2] - a[2];
      let nx = uy * vz - uz * vy;
      let ny = uz * vx - ux * vz;
      let nz = ux * vy - uy * vx;
      const len = Math.hypot(nx, ny, nz) || 1;
      nx /= len; ny /= len; nz /= len;

      [a, b, c].forEach((p) => {
        pos.push(p[0], p[1], p[2]);
        norm.push(nx, ny, nz);
      });
      idx.push(offset, offset + 1, offset + 2);
      offset += 3;
    });

    return {
      positions: new Float32Array(pos),
      normals: new Float32Array(norm),
      indices: new Uint16Array(idx)
    };
  }

  /* Build an icosphere by subdividing an icosahedron — smoother sphere for particles */
  function buildIcosphereMesh(radius, subdivisions) {
    const t = (1.0 + Math.sqrt(5.0)) / 2.0;
    let verts = [
      [-1, t, 0], [1, t, 0], [-1, -t, 0], [1, -t, 0],
      [0, -1, t], [0, 1, t], [0, -1, -t], [0, 1, -t],
      [t, 0, -1], [t, 0, 1], [-t, 0, -1], [-t, 0, 1]
    ];
    let faces = [
      [0, 11, 5], [0, 5, 1], [0, 1, 7], [0, 7, 10], [0, 10, 11],
      [1, 5, 9], [5, 11, 4], [11, 10, 2], [10, 7, 6], [7, 1, 8],
      [3, 9, 4], [3, 4, 2], [3, 2, 6], [3, 6, 8], [3, 8, 9],
      [4, 9, 5], [2, 4, 11], [6, 2, 10], [8, 6, 7], [9, 8, 1]
    ];

    const midCache = {};
    function addMidpoint(a, b) {
      const key = Math.min(a, b) + '_' + Math.max(a, b);
      if (midCache[key] !== undefined) return midCache[key];
      const va = verts[a], vb = verts[b];
      verts.push([(va[0] + vb[0]) / 2, (va[1] + vb[1]) / 2, (va[2] + vb[2]) / 2]);
      midCache[key] = verts.length - 1;
      return midCache[key];
    }

    for (let s = 0; s < (subdivisions || 1); s++) {
      const newFaces = [];
      faces.forEach(function (tri) {
        const a = addMidpoint(tri[0], tri[1]);
        const b = addMidpoint(tri[1], tri[2]);
        const c = addMidpoint(tri[2], tri[0]);
        newFaces.push([tri[0], a, c], [tri[1], b, a], [tri[2], c, b], [a, b, c]);
      });
      faces = newFaces;
    }

    // Normalize to sphere
    verts.forEach(function (v) {
      const len = Math.hypot(v[0], v[1], v[2]);
      v[0] = (v[0] / len) * radius;
      v[1] = (v[1] / len) * radius;
      v[2] = (v[2] / len) * radius;
    });

    const pos = [];
    const norm = [];
    const idx = [];
    let offset = 0;

    faces.forEach(function (tri) {
      const a = verts[tri[0]], b = verts[tri[1]], c = verts[tri[2]];
      const ux = b[0] - a[0], uy = b[1] - a[1], uz = b[2] - a[2];
      const vx = c[0] - a[0], vy = c[1] - a[1], vz = c[2] - a[2];
      let nx = uy * vz - uz * vy;
      let ny = uz * vx - ux * vz;
      let nz = ux * vy - uy * vx;
      const len = Math.hypot(nx, ny, nz) || 1;
      nx /= len; ny /= len; nz /= len;

      [a, b, c].forEach(function (p) {
        pos.push(p[0], p[1], p[2]);
        norm.push(nx, ny, nz);
      });
      idx.push(offset, offset + 1, offset + 2);
      offset += 3;
    });

    return {
      positions: new Float32Array(pos),
      normals: new Float32Array(norm),
      indices: new Uint16Array(idx)
    };
  }

  /* ==========================================================================
     3. WebGL 3D Architectural Hero Canvas — Premium v2
     ========================================================================== */
  function initHero3DArchitecture() {
    const canvas = document.getElementById('hero3dCanvas');
    if (!canvas || prefersReducedMotion) return;

    const gl = canvas.getContext('webgl', { alpha: true, antialias: true, powerPreference: 'high-performance' });
    if (!gl) return;

    /* ---- Shaders ---- */
    const vsSource = `
      attribute vec3 aPosition;
      attribute vec3 aNormal;
      uniform mat4 uProjection;
      uniform mat4 uModelView;
      varying vec3 vNormal;
      varying vec3 vViewPos;
      varying vec3 vLocalPos;
      void main(void) {
        vLocalPos = aPosition;
        vec4 mvPos = uModelView * vec4(aPosition, 1.0);
        vViewPos = mvPos.xyz;
        vNormal = normalize(mat3(uModelView) * aNormal);
        gl_Position = uProjection * mvPos;
      }
    `;

    const fsSource = `
      precision mediump float;
      varying vec3 vNormal;
      varying vec3 vViewPos;
      varying vec3 vLocalPos;
      uniform vec3 uBaseColor;
      uniform vec3 uRimColor;
      uniform float uMetalness;
      uniform float uIsGrid;
      uniform float uIsGlow;
      uniform float uIsGlobe;
      uniform float uEmissive;
      uniform float uAlpha;
      uniform float uTime;
      void main(void) {
        // Volumetric soft-edge aura sphere (zero polygon silhouette)
        if (uIsGlow > 0.5) {
          vec3 N = normalize(vNormal);
          vec3 V = normalize(-vViewPos);
          float coreFalloff = pow(max(dot(N, V), 0.0), 2.8);
          gl_FragColor = vec4(uRimColor, coreFalloff * uAlpha);
          return;
        }

        // Realistic night-side 3D Earth horizon dome with fine city-light clusters & smooth lateral fade
        if (uIsGlobe > 0.5) {
          vec3 N = normalize(vNormal);
          vec3 V = normalize(-vViewPos);
          vec3 P = normalize(vLocalPos);

          float lon = atan(P.z, P.x);
          float lat = asin(clamp(P.y, -1.0, 1.0));

          // Whisper-thin planetary coordinate arcs (subtle texture, never overpowering)
          float mer = smoothstep(0.982, 0.999, abs(cos(lon * 10.0)));
          float par = smoothstep(0.984, 0.999, abs(cos(lat * 8.0)));
          float globeGrid = max(mer, par) * 0.11;

          // Multi-scale orbital city-light networks in warm gold/orange (#FF8C00 / #FFD166)
          float macroLand = sin(lon * 2.3 + 0.6) * cos(lat * 3.1 - 0.15)
                          + sin(lon * 4.8 - lat * 2.5) * 0.58;
          float landMask = smoothstep(-0.08, 0.72, macroLand);
          float clusterA = smoothstep(0.45, 1.05, sin(lon * 19.0 + uTime * 0.03) * sin(lat * 23.0) + cos(lon * 29.0 - lat * 17.0) * 0.65);
          float pinpointB = pow(max(sin(lon * 47.0 - 0.4) * cos(lat * 53.0 + 0.2), 0.0), 6.0);
          float pinpointC = pow(max(cos(lon * 67.0 + lat * 61.0), 0.0), 8.0);
          float cityLights = landMask * (clusterA * 0.55 + pinpointB * 1.15 + pinpointC * 1.45);

          // Luminous cyan-blue atmospheric horizon corona hugging the planetary limb
          float viewDot = max(dot(N, V), 0.0);
          float fresnel = pow(1.0 - viewDot, 2.85);
          float outerRim = pow(1.0 - viewDot, 5.2);
          float horizonBand = smoothstep(-0.22, 0.68, P.y);
          float warmFlank = smoothstep(0.05, 0.85, N.x) * fresnel;

          vec3 oceanNavy = vec3(0.018, 0.055, 0.135);
          vec3 cyanAtmos = vec3(0.14, 0.84, 0.96);
          vec3 royalBlue = vec3(0.06, 0.40, 0.88);
          vec3 orangeLight = vec3(1.0, 0.55, 0.05);
          vec3 goldSpark = vec3(1.0, 0.84, 0.46);

          vec3 col = oceanNavy
            + royalBlue * (fresnel * 0.92 + globeGrid * 0.4)
            + cyanAtmos * ((fresnel * 0.78 + outerRim * 1.15) * horizonBand + globeGrid * 0.35)
            + orangeLight * (cityLights * 0.88 + warmFlank * 0.58)
            + goldSpark * (landMask * (pinpointB * 0.7 + pinpointC * 1.2));

          // Deep smooth fade from both lateral limbs into dark navy background
          float sideFade = pow(1.0 - smoothstep(0.18, 0.88, abs(N.x)), 1.35);
          col = min(col, vec3(0.90, 0.88, 0.86)) * (0.14 + sideFade * 0.86);
          float globeAlpha = uAlpha * (0.04 + sideFade * 0.96);

          gl_FragColor = vec4(col, globeAlpha);
          return;
        }

        // Grid floor rendering with depth + radial + lateral side fog
        if (uIsGrid > 0.5) {
          float radial = length(vLocalPos.xz);
          float sideGridFade = 1.0 - smoothstep(3.2, 8.2, abs(vLocalPos.x));
          float edgeFade = (1.0 - smoothstep(3.0, 8.6, radial)) * sideGridFade;
          float depthFade = smoothstep(-19.0, -5.5, vViewPos.z);
          float alpha = clamp(depthFade * edgeFade * 0.30, 0.0, 0.30);
          float horizonGlow = exp(-radial * 0.28) * 0.24 * sideGridFade;
          float warmMask = smoothstep(-1.5, 4.5, vLocalPos.x) * exp(-radial * 0.32) * sideGridFade;
          vec3 gridColor = uRimColor
            + vec3(horizonGlow * 0.10, horizonGlow * 0.26, horizonGlow * 0.42)
            + vec3(1.0, 0.55, 0.0) * (warmMask * 0.44);
          gl_FragColor = vec4(gridColor, alpha + horizonGlow * 0.12 + warmMask * 0.10);
          return;
        }

        vec3 N = normalize(vNormal);
        vec3 V = normalize(-vViewPos);

        // Three-point lighting setup (key, fill, rim)
        vec3 L1 = normalize(vec3(-0.5, 0.9, 0.6));  // Key light
        vec3 L2 = normalize(vec3(0.7, -0.2, 0.5));   // Fill light
        vec3 L3 = normalize(vec3(0.0, -0.6, -0.8));   // Backlight

        float diff1 = max(dot(N, L1), 0.0);
        float diff2 = max(dot(N, L2), 0.0) * 0.38;
        float diff3 = max(dot(N, L3), 0.0) * 0.18;

        // Blinn-Phong specular with metalness
        vec3 H1 = normalize(L1 + V);
        vec3 H3 = normalize(L3 + V);
        float spec1 = pow(max(dot(N, H1), 0.0), 52.0) * (0.5 + uMetalness * 0.5);
        float spec3 = pow(max(dot(N, H3), 0.0), 36.0) * uMetalness * 0.3;

        // Fresnel rim light
        float fresnel = pow(1.0 - max(dot(N, V), 0.0), 3.2);

        // Atmospheric depth fog
        float fogFactor = smoothstep(-28.0, -6.0, vViewPos.z);

        vec3 ambient = uBaseColor * 0.28;
        vec3 lit = ambient
          + uBaseColor * (diff1 * 0.92 + diff2 + diff3)
          + vec3(spec1 + spec3)
          + uRimColor * fresnel * 0.68;

        // Emissive glow contribution
        lit += uBaseColor * uEmissive * 1.6;

        // Apply fog
        vec3 fogColor = vec3(0.02, 0.04, 0.08);
        lit = mix(fogColor, lit, fogFactor);

        gl_FragColor = vec4(lit, uAlpha);
      }
    `;

    function compileShader(type, src) {
      const s = gl.createShader(type);
      gl.shaderSource(s, src);
      gl.compileShader(s);
      if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) {
        gl.deleteShader(s);
        return null;
      }
      return s;
    }

    const vs = compileShader(gl.VERTEX_SHADER, vsSource);
    const fs = compileShader(gl.FRAGMENT_SHADER, fsSource);
    if (!vs || !fs) return;

    const prog = gl.createProgram();
    gl.attachShader(prog, vs);
    gl.attachShader(prog, fs);
    gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) return;

    gl.useProgram(prog);

    const locPos = gl.getAttribLocation(prog, 'aPosition');
    const locNorm = gl.getAttribLocation(prog, 'aNormal');
    const uProj = gl.getUniformLocation(prog, 'uProjection');
    const uMV = gl.getUniformLocation(prog, 'uModelView');
    const uBaseColor = gl.getUniformLocation(prog, 'uBaseColor');
    const uRimColor = gl.getUniformLocation(prog, 'uRimColor');
    const uMetal = gl.getUniformLocation(prog, 'uMetalness');
    const uIsGrid = gl.getUniformLocation(prog, 'uIsGrid');
    const uIsGlow = gl.getUniformLocation(prog, 'uIsGlow');
    const uIsGlobe = gl.getUniformLocation(prog, 'uIsGlobe');
    const uEmissive = gl.getUniformLocation(prog, 'uEmissive');
    const uAlpha = gl.getUniformLocation(prog, 'uAlpha');
    const uTime = gl.getUniformLocation(prog, 'uTime');

    function createGpuMesh(mesh) {
      const posBuf = gl.createBuffer();
      gl.bindBuffer(gl.ARRAY_BUFFER, posBuf);
      gl.bufferData(gl.ARRAY_BUFFER, mesh.positions, gl.STATIC_DRAW);

      const normBuf = gl.createBuffer();
      gl.bindBuffer(gl.ARRAY_BUFFER, normBuf);
      gl.bufferData(gl.ARRAY_BUFFER, mesh.normals, gl.STATIC_DRAW);

      const idxBuf = gl.createBuffer();
      gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, idxBuf);
      gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, mesh.indices, gl.STATIC_DRAW);

      return { posBuf, normBuf, idxBuf, count: mesh.indices.length };
    }

    /* ---- Build GPU Meshes ---- */
    const slabBase = createGpuMesh(buildBoxMesh(2.9, 0.18, 2.9));
    const slabMid = createGpuMesh(buildBoxMesh(2.1, 0.16, 2.1));
    const slabTop = createGpuMesh(buildBoxMesh(1.4, 0.14, 1.4));
    const ringOuter = createGpuMesh(buildTorusRingMesh(2.22, 0.052, 20, 72));
    const ringMid = createGpuMesh(buildTorusRingMesh(1.62, 0.042, 18, 64));
    const ringInner = createGpuMesh(buildTorusRingMesh(1.08, 0.034, 16, 56));
    const corePrism = createGpuMesh(buildOctahedronMesh(0.64));
    const tinyFacet = createGpuMesh(buildOctahedronMesh(0.2));
    const glowSphere = createGpuMesh(buildIcosphereMesh(1.18, 2));
    const horizonGlobe = createGpuMesh(buildIcosphereMesh(4.95, 3));

    /* ---- Perspective Floor Grid ---- */
    const gridPos = [];
    const gridNorm = [];
    const gridExtent = 13;
    const gridStep = 0.9;
    for (let g = -gridExtent; g <= gridExtent; g += gridStep) {
      gridPos.push(g, 0, -gridExtent, g, 0, gridExtent);
      gridNorm.push(0, 1, 0, 0, 1, 0);
      gridPos.push(-gridExtent, 0, g, gridExtent, 0, g);
      gridNorm.push(0, 1, 0, 0, 1, 0);
    }
    const gridPosBuf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, gridPosBuf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(gridPos), gl.STATIC_DRAW);
    const gridNormBuf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, gridNormBuf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(gridNorm), gl.STATIC_DRAW);
    const gridVertCount = gridPos.length / 3;

    /* ---- Constellation Lines between sculpture elements ---- */
    // These will be drawn dynamically each frame using computed positions

    function drawGpuMesh(gpu, mvMatrix, baseColor, rimColor, metalness, emissive, alpha, isGlow, isGlobe) {
      gl.uniform1f(uIsGrid, 0.0);
      gl.uniform1f(uIsGlow, isGlow ? 1.0 : 0.0);
      gl.uniform1f(uIsGlobe, isGlobe ? 1.0 : 0.0);
      gl.uniform1f(uEmissive, emissive || 0.0);
      gl.uniform1f(uAlpha, alpha !== undefined ? alpha : 0.96);

      gl.bindBuffer(gl.ARRAY_BUFFER, gpu.posBuf);
      gl.enableVertexAttribArray(locPos);
      gl.vertexAttribPointer(locPos, 3, gl.FLOAT, false, 0, 0);

      gl.bindBuffer(gl.ARRAY_BUFFER, gpu.normBuf);
      gl.enableVertexAttribArray(locNorm);
      gl.vertexAttribPointer(locNorm, 3, gl.FLOAT, false, 0, 0);

      gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, gpu.idxBuf);

      gl.uniformMatrix4fv(uMV, false, mvMatrix);
      gl.uniform3fv(uBaseColor, baseColor);
      gl.uniform3fv(uRimColor, rimColor);
      gl.uniform1f(uMetal, metalness);

      gl.drawElements(gl.TRIANGLES, gpu.count, gl.UNSIGNED_SHORT, 0);
    }

    /* ---- Constellation line drawing ---- */
    const linePosData = new Float32Array(60); // Max 10 lines x 2 verts x 3 coords
    const lineNormData = new Float32Array(60);
    for (let i = 0; i < 60; i++) lineNormData[i] = (i % 3 === 1) ? 1.0 : 0.0;
    const linePosBuf = gl.createBuffer();
    const lineNormBuf2 = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, lineNormBuf2);
    gl.bufferData(gl.ARRAY_BUFFER, lineNormData, gl.STATIC_DRAW);

    function drawConstellationLines(points, t) {
      if (points.length < 2) return;
      let idx = 0;
      // Connect adjacent points
      for (let i = 0; i < points.length - 1 && idx < 54; i++) {
        linePosData[idx++] = points[i][0];
        linePosData[idx++] = points[i][1];
        linePosData[idx++] = points[i][2];
        linePosData[idx++] = points[i + 1][0];
        linePosData[idx++] = points[i + 1][1];
        linePosData[idx++] = points[i + 1][2];
      }
      // Connect last to first for a subtle closed loop
      if (points.length > 2 && idx < 60) {
        const last = points[points.length - 1];
        const first = points[0];
        linePosData[idx++] = last[0];
        linePosData[idx++] = last[1];
        linePosData[idx++] = last[2];
        linePosData[idx++] = first[0];
        linePosData[idx++] = first[1];
        linePosData[idx++] = first[2];
      }
      const vertCount = idx / 3;
      if (vertCount < 2) return;

      gl.bindBuffer(gl.ARRAY_BUFFER, linePosBuf);
      gl.bufferData(gl.ARRAY_BUFFER, linePosData.subarray(0, idx), gl.DYNAMIC_DRAW);
      gl.enableVertexAttribArray(locPos);
      gl.vertexAttribPointer(locPos, 3, gl.FLOAT, false, 0, 0);

      gl.bindBuffer(gl.ARRAY_BUFFER, lineNormBuf2);
      gl.enableVertexAttribArray(locNorm);
      gl.vertexAttribPointer(locNorm, 3, gl.FLOAT, false, 0, 0);

      const lineMV = mat4Identity();
      gl.uniformMatrix4fv(uMV, false, lineMV);
      gl.uniform3fv(uBaseColor, [0.14, 0.42, 0.82]);
      gl.uniform3fv(uRimColor, [0.3, 0.72, 0.98]);
      gl.uniform1f(uMetal, 0.2);
      gl.uniform1f(uIsGrid, 0.0);
      gl.uniform1f(uIsGlow, 0.0);
      gl.uniform1f(uIsGlobe, 0.0);
      gl.uniform1f(uEmissive, 0.4 + Math.sin(t * 2.0) * 0.15);
      gl.uniform1f(uAlpha, 0.22 + Math.sin(t * 1.5) * 0.08);

      gl.drawArrays(gl.LINES, 0, vertCount);
    }

    let width = 0;
    let height = 0;
    function resize() {
      const parent = canvas.parentElement;
      if (!parent) return;
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      const w = parent.clientWidth;
      const h = parent.clientHeight;
      if (w === 0 || h === 0) return;
      width = canvas.width = Math.floor(w * dpr);
      height = canvas.height = Math.floor(h * dpr);
      gl.viewport(0, 0, width, height);
    }

    resize();
    window.addEventListener('resize', resize, { passive: true });

    let pointerX = 0;
    let pointerY = 0;
    let targetPX = 0;
    let targetPY = 0;

    window.addEventListener('mousemove', (e) => {
      targetPX = (e.clientX / window.innerWidth - 0.5) * 2;
      targetPY = (e.clientY / window.innerHeight - 0.5) * 2;
    }, { passive: true });

    let isVisible = true;
    if ('IntersectionObserver' in window) {
      const obs = new IntersectionObserver((entries) => {
        isVisible = entries[0].isIntersecting;
      }, { threshold: 0.05 });
      obs.observe(canvas.parentElement || canvas);
    }

    gl.enable(gl.DEPTH_TEST);
    gl.enable(gl.CULL_FACE);
    gl.enable(gl.BLEND);
    gl.blendFunc(gl.SRC_ALPHA, gl.ONE_MINUS_SRC_ALPHA);

    const start = performance.now();

    // Helper: extract world position from a transform matrix
    function getPos(m) { return [m[12], m[13], m[14]]; }

    function render(now) {
      requestAnimationFrame(render);
      if (!isVisible || width === 0 || height === 0) return;

      const t = (now - start) * 0.001;
      pointerX += (targetPX - pointerX) * 0.055;
      pointerY += (targetPY - pointerY) * 0.055;
      gl.uniform1f(uTime, t);

      gl.clearColor(0, 0, 0, 0);
      gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

      const aspect = width / height;
      const proj = mat4Perspective(Math.PI / 4.5, aspect, 0.1, 50.0);
      gl.uniformMatrix4fv(uProj, false, proj);

      /* ---- 0. 3D Illuminated Earth Horizon Dome (bottom-center cosmic wave horizon) ---- */
      const globeY = aspect > 1.05 ? -7.45 : -7.85;
      const globeZ = aspect > 1.05 ? -14.1 : -14.8;
      let mGlobeAtmos = mat4Identity();
      mGlobeAtmos = mat4Translate(mGlobeAtmos, pointerX * 0.12, globeY, globeZ - 0.15);
      mGlobeAtmos = mat4Scale(mGlobeAtmos, 5.4, 5.4, 5.4);
      gl.depthMask(false);
      drawGpuMesh(glowSphere, mGlobeAtmos, [0.05, 0.37, 0.84], [0.13, 0.83, 0.93], 0.0, 0.0, 0.56, true, false);
      gl.depthMask(true);

      let mGlobe = mat4Identity();
      mGlobe = mat4Translate(mGlobe, pointerX * 0.12, globeY, globeZ);
      mGlobe = mat4RotateX(mGlobe, 0.22 + pointerY * 0.04);
      mGlobe = mat4RotateY(mGlobe, t * 0.055 + pointerX * 0.1);
      mGlobe = mat4Scale(mGlobe, 1.1, 1.1, 1.1);
      drawGpuMesh(horizonGlobe, mGlobe, [0.04, 0.16, 0.36], [0.13, 0.83, 0.93], 0.55, 0.3, 0.98, false, true);

      let mGlobeWarm = mat4Identity();
      mGlobeWarm = mat4Translate(mGlobeWarm, 2.2 + pointerX * 0.12, globeY + 1.85, globeZ - 0.35);
      mGlobeWarm = mat4Scale(mGlobeWarm, 3.1, 2.0, 2.6);
      gl.depthMask(false);
      drawGpuMesh(glowSphere, mGlobeWarm, [1.0, 0.55, 0.0], [1.0, 0.56, 0.06], 0.0, 0.0, 0.24, true, false);
      gl.depthMask(true);

      /* ---- 1. Depth-fogged perspective floor grid ---- */
      let floorM = mat4Identity();
      floorM = mat4Translate(floorM, 0.0, -2.05, -10.5);
      floorM = mat4RotateX(floorM, 0.22 + pointerY * 0.03);
      floorM = mat4RotateY(floorM, pointerX * 0.04);
      gl.bindBuffer(gl.ARRAY_BUFFER, gridPosBuf);
      gl.enableVertexAttribArray(locPos);
      gl.vertexAttribPointer(locPos, 3, gl.FLOAT, false, 0, 0);
      gl.bindBuffer(gl.ARRAY_BUFFER, gridNormBuf);
      gl.enableVertexAttribArray(locNorm);
      gl.vertexAttribPointer(locNorm, 3, gl.FLOAT, false, 0, 0);
      gl.uniformMatrix4fv(uMV, false, floorM);
      gl.uniform3fv(uBaseColor, [0.06, 0.14, 0.28]);
      gl.uniform3fv(uRimColor, [0.2, 0.58, 0.92]);
      gl.uniform1f(uMetal, 0.2);
      gl.uniform1f(uIsGrid, 1.0);
      gl.uniform1f(uIsGlow, 0.0);
      gl.uniform1f(uIsGlobe, 0.0);
      gl.uniform1f(uEmissive, 0.0);
      gl.uniform1f(uAlpha, 1.0);
      gl.drawArrays(gl.LINES, 0, gridVertCount);

      /* ---- 2. Main sculptural assembly ---- */
      // Centered cleanly in the negative-space pocket above the horizon globe & beside showcase chassis
      const offsetX = aspect > 1.05 ? 0.12 : 0.0;
      const offsetY = aspect > 1.05 ? 0.92 : -0.15;
      const camZ = aspect > 1.05 ? -13.4 : -10.5;

      let base = mat4Identity();
      base = mat4Translate(base, offsetX, offsetY, camZ);
      base = mat4RotateX(base, 0.42 + pointerY * 0.12);
      base = mat4RotateY(base, -0.5 + pointerX * 0.2 + t * 0.12);

      const constellationPoints = [];

      // 2a. Three stepped architectural plinths (Navy slabs with glowing Electric Orange #FF8C00 rims)
      let mSlab1 = mat4Translate(base, 0, -1.1, 0);
      mSlab1 = mat4RotateY(mSlab1, Math.sin(t * 0.3) * 0.06);
      drawGpuMesh(slabBase, mSlab1, [0.06, 0.12, 0.22], [1.0, 0.55, 0.0], 0.6, 0.05);
      constellationPoints.push(getPos(mSlab1));

      let mSlab2 = mat4Translate(base, 0, -0.65, 0);
      mSlab2 = mat4RotateY(mSlab2, Math.PI * 0.25 + Math.cos(t * 0.25) * 0.06);
      drawGpuMesh(slabMid, mSlab2, [0.08, 0.15, 0.28], [1.0, 0.58, 0.04], 0.65, 0.06);

      let mSlab3 = mat4Translate(base, 0, -0.28, 0);
      mSlab3 = mat4RotateY(mSlab3, -Math.PI * 0.125 + Math.sin(t * 0.2) * 0.04);
      drawGpuMesh(slabTop, mSlab3, [0.1, 0.18, 0.33], [1.0, 0.64, 0.1], 0.7, 0.08);

      // Warm orange plinth aura glow beneath stepped slabs
      let mPlinthGlow = mat4Translate(base, 0, -0.82, 0);
      mPlinthGlow = mat4Scale(mPlinthGlow, 1.35, 0.38, 1.35);
      gl.depthMask(false);
      drawGpuMesh(glowSphere, mPlinthGlow, [1.0, 0.55, 0.0], [1.0, 0.55, 0.0], 0.0, 0.0, 0.26, true);
      gl.depthMask(true);

      // 2b. Three concentric precision gyroscope rings (Blue & Cyan)
      let mRing1 = mat4Translate(base, 0, 0.5, 0);
      mRing1 = mat4RotateZ(mRing1, 0.42);
      mRing1 = mat4RotateY(mRing1, t * 0.3);
      drawGpuMesh(ringOuter, mRing1, [0.08, 0.42, 0.82], [0.13, 0.83, 0.93], 0.92, 0.08);
      constellationPoints.push(getPos(mRing1));

      let mRing2 = mat4Translate(base, 0, 0.55, 0);
      mRing2 = mat4RotateX(mRing2, -0.52);
      mRing2 = mat4RotateZ(mRing2, -t * 0.4);
      drawGpuMesh(ringMid, mRing2, [0.04, 0.37, 0.84], [0.13, 0.83, 0.93], 0.88, 0.1);

      let mRing3 = mat4Translate(base, 0, 0.48, 0);
      mRing3 = mat4RotateY(mRing3, t * 0.55);
      mRing3 = mat4RotateX(mRing3, 0.65);
      drawGpuMesh(ringInner, mRing3, [0.13, 0.83, 0.93], [0.45, 0.92, 1.0], 0.85, 0.12);

      // 2c. Volumetric soft-edge aura sphere around core
      const pulseIntensity = 0.35 + Math.sin(t * 1.8) * 0.15 + Math.sin(t * 3.1) * 0.06;
      let mGlow = mat4Translate(base, 0, 0.55 + Math.sin(t * 1.2) * 0.08, 0);
      mGlow = mat4Scale(mGlow, 1.0 + pulseIntensity * 0.14, 1.0 + pulseIntensity * 0.14, 1.0 + pulseIntensity * 0.14);
      gl.depthMask(false);
      drawGpuMesh(glowSphere, mGlow, [0.04, 0.37, 0.84], [0.13, 0.83, 0.93], 0.0, 0.0, 0.3 + pulseIntensity * 0.16, true);
      gl.depthMask(true);

      // 2d. Floating cyan/blue core octahedron with breathing pulse
      const corePulse = 0.08 + Math.sin(t * 1.4) * 0.04;
      let mCore = mat4Translate(base, 0, 0.55 + Math.sin(t * 1.2) * 0.08, 0);
      mCore = mat4RotateY(mCore, t * 0.55);
      mCore = mat4RotateX(mCore, Math.sin(t * 0.45) * 0.22);
      drawGpuMesh(corePrism, mCore, [0.13, 0.72, 0.95], [0.65, 0.94, 1.0], 0.95, corePulse + 0.12);
      constellationPoints.push(getPos(mCore));

      // 2e. Orbiting micro-facets with subtle orange AI accent rims
      const microSpots = [
        [0.4, 3.25, -16.2, 0.35, 0.0],
        [6.1, -1.8, -14.8, -0.45, 0.4],
        [-0.3, -2.55, -16.8, 0.25, 0.8],
        [4.2, 3.1, -17.2, -0.3, 1.2],
        [0.5, -3.55, -14.8, 0.5, 2.0]
      ];
      microSpots.forEach((sp, i) => {
        let mf = mat4Identity();
        const wobbleX = Math.sin(t * 0.6 + sp[4]) * 0.2;
        const wobbleY = Math.cos(t * 0.4 + sp[4]) * 0.15;
        mf = mat4Translate(mf,
          sp[0] + pointerX * 0.15 + wobbleX,
          sp[1] + Math.sin(t + i) * 0.14 - pointerY * 0.12 + wobbleY,
          sp[2]
        );
        mf = mat4RotateY(mf, t * sp[3]);
        mf = mat4RotateX(mf, t * 0.25 + sp[4]);
        const isOrangeAccent = i % 2 === 0;
        drawGpuMesh(
          tinyFacet,
          mf,
          isOrangeAccent ? [0.75, 0.38, 0.04] : [0.1, 0.22, 0.42],
          isOrangeAccent ? [1.0, 0.55, 0.0] : [0.13, 0.83, 0.93],
          0.8,
          isOrangeAccent ? 0.12 : 0.05
        );
        constellationPoints.push(getPos(mf));
      });

      // 2f. Draw constellation lines connecting key sculpture points
      drawConstellationLines(constellationPoints, t);
    }

    requestAnimationFrame(render);
  }

  /* ==========================================================================
     4. Cursor-Driven 3D Tilt & Specular Light Tracking
     ========================================================================== */
  function initSpatialCards3D() {
    if (prefersReducedMotion) return;

    // Hero 3D Chassis gentle pointer follow
    const heroVisual = document.querySelector('.hero-visual');
    const techFrame = heroVisual ? heroVisual.querySelector('.tech-frame') : null;
    if (heroVisual && techFrame && window.innerWidth > 1100) {
      heroVisual.addEventListener('mousemove', (e) => {
        const rect = heroVisual.getBoundingClientRect();
        const nx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        const ny = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        const rx = (5 - ny * 4).toFixed(2);
        const ry = (-10 + nx * 6).toFixed(2);
        techFrame.style.transform = `rotateY(${ry}deg) rotateX(${rx}deg) translateZ(8px)`;
      });

      heroVisual.addEventListener('mouseleave', () => {
        techFrame.style.transform = 'rotateY(-10deg) rotateX(5deg) translateZ(0)';
      });
    }

    // Specular Cursor Light across all site cards, panels, and interactive surfaces
    const LIT_SURFACE_SELECTOR = [
      '.service-row-card',
      '.why-dark-card',
      '.testimonial-card',
      '.card',
      '.leader-card',
      '.division-card',
      '.price-card-modern',
      '.clean-project-card',
      '.project-card',
      '.industry-slider-card',
      '.problem-path-card',
      '.process-pill-box',
      '.process-card-container',
      '.case-study-visual-card',
      '.work-card-media',
      '.sim-workbench-card',
      '.sim-rag-sidebar',
      '.sim-query-card',
      '.sim-sandbox-notice',
      '.form-card',
      '.contact-panel',
      '.contact-form-shell',
      '.contact-direct-row',
      '.contact-topic-btn',
      '.contact-pillar-btn',
      '.careers-card',
      '.careers-job-card',
      '.careers-detail-panel',
      '.careers-form-panel',
      '.careers-portal-strip',
      '.portal-timeline-item',
      '.guarantee-item',
      '.pricing-guarantee-strip',
      '.faq-item',
      '.division-faq-item',
      '.division-steps li',
      '.faq-accordion-box details',
      '.cta-section-wrap',
      '.footer-cta-card',
      '.article-reader-shell',
      '.project-detail-hero',
      '.project-stat-triplets > div',
      '.project-feature-tile',
      '.obsidian-lit-panel'
    ].join(', ');

    let pendingTarget = null;
    let pendingX = 0;
    let pendingY = 0;
    let spotlightRafId = 0;

    function flushCursorSpotlight() {
      spotlightRafId = 0;
      let node = pendingTarget instanceof Element ? pendingTarget.closest(LIT_SURFACE_SELECTOR) : null;
      while (node) {
        const rect = node.getBoundingClientRect();
        if (rect.width > 0 && rect.height > 0) {
          const px = (((pendingX - rect.left) / rect.width) * 100).toFixed(1);
          const py = (((pendingY - rect.top) / rect.height) * 100).toFixed(1);
          node.style.setProperty('--spot-x', `${px}%`);
          node.style.setProperty('--spot-y', `${py}%`);
        }
        node = node.parentElement ? node.parentElement.closest(LIT_SURFACE_SELECTOR) : null;
      }
    }

    document.addEventListener('pointermove', (e) => {
      if (e.pointerType === 'touch') return;
      pendingTarget = e.target;
      pendingX = e.clientX;
      pendingY = e.clientY;
      if (!spotlightRafId) {
        spotlightRafId = requestAnimationFrame(flushCursorSpotlight);
      }
    }, { passive: true });
  }

  /* ==========================================================================
     5. 3D Coverflow Stage Prev/Next Angle Sync + Counter
     ========================================================================== */
  function initCoverflowSync() {
    const track = document.getElementById('caseSliderTrack');
    const counter = document.getElementById('caseSlideCounter');
    if (!track) return;

    const slides = Array.from(track.querySelectorAll('.case-slide-item'));
    if (!slides.length) return;

    function syncSlides() {
      let activeIdx = slides.findIndex((s) => s.classList.contains('is-active-center'));
      if (activeIdx < 0) activeIdx = 1;

      slides.forEach((s, i) => {
        s.classList.toggle('is-prev-slide', i < activeIdx);
        s.classList.toggle('is-next-slide', i > activeIdx);
      });

      if (counter) {
        const num = String(activeIdx + 1).padStart(2, '0');
        const total = String(slides.length).padStart(2, '0');
        counter.textContent = `${num} / ${total}`;
      }
    }

    const observer = new MutationObserver(syncSlides);
    slides.forEach((s) => observer.observe(s, { attributes: true, attributeFilter: ['class'] }));
    syncSlides();
  }

  document.addEventListener('DOMContentLoaded', () => {
    initHero3DArchitecture();
    initSpatialCards3D();
    initCoverflowSync();
  });
})();
