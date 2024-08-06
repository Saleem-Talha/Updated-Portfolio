  <!-- ECharts scripts -->
  <script>
        // ECharts pie chart configuration
        const pieChartOptions = {
            backgroundColor: "",
            title: {
                text: "Customized Pie",
                left: "center",
                top: 20,
                bottom: 5,

                textStyle: {
                    color: "#ccc",
                },
            },
            tooltip: {
                trigger: "item",
            },
            visualMap: {
                show: false,
                min: 80,
                max: 600,
                inRange: {
                    colorLightness: [0, 1],
                },
            },
            series: [
                {
                    name: "Skill Level",
                    type: "pie",
                    radius: "55%",
                    center: ["50%", "50%"],
                    roseType: "radius",
                    label: {
                        color: "rgb(104, 222, 110);",
                    },
                    labelLine: {
                        lineStyle: {
                            color: "rgba(255, 255, 255, 0.3)",
                        },
                        smooth: 0.2,
                        length: 10,
                        length2: 20,
                    },
                    itemStyle: {
                        shadowBlur: 200,
                        shadowColor: "rgba(0, 0, 0, 0.5)",
                    },
                    animationType: "scale",
                    animationEasing: "elasticOut",
                    animationDelay: function (idx) {
                        return Math.random() * 200;
                    },
                },
            ],
        };

        const webSkillsData = {
            ...pieChartOptions,
            title: {
                text: "Frontend Development",
                left: "center",
                top: 20,

                textStyle: {
                    color: "rgba(255, 255, 255, 0.3)",
                },
            },
            series: [
                {
                    ...pieChartOptions.series[0],
                    data: [
                        { value: 210, name: "JavaScript", tooltip: "<span style='font-weight: 600;'>JavaScript</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Intermediate</span>" },
                        { value: 270, name: "Bootstrap", tooltip: "<span style='font-weight: 600;'>Bootstrap</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experieced</span>" },
                        { value: 370, name: "Website Development", tooltip: "<span style='font-weight: 600;'>Website Development</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Skilled</span>" },
                        { value: 470, name: "Performance Optimization", tooltip: "<span style='font-weight: 600;'>Performance Optimization</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Proficient</span>" },
                        { value: 500, name: "Responssive Layouts", tooltip: "<span style='font-weight: 600;'>Responssive Layouts</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Skilled</span>" },
                        { value: 510, name: "HTML & CSS", tooltip: "<span style='font-weight: 600;'>HTML & CSS</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Expert</span>" },
                    ],
                    itemStyle: {
                        color: "#5470c6",
                    },
                    tooltip: {
                        formatter: function (params) {
                            return params.data.tooltip;
                        },
                    },
                },
            ],
        };

        // Data for "UI/UX Design Skills" Pie Chart
        const uiuxSkillsData = {
            ...pieChartOptions,
            title: {
                text: "UI/UX Design",
                left: "center",
                top: 20,
                textStyle: {
                    color: "rgba(255, 255, 255, 0.3)",
                },
            },
            series: [
                {
                    ...pieChartOptions.series[0],
                    data: [
                        { value: 250, name: "3D Designs", tooltip: "<span style='font-weight: 600;'>3D Designs</span><br><span style='color: red;'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Intermediate</span>" },
                        { value: 300, name: "Presentations", tooltip: "<span style='font-weight: 600;'>Presentations</span><br><span style='color: red;'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Skilled</span>" },

                        { value: 400, name: "Logo Designs", tooltip: "<span style='font-weight: 600;'>Logo Designs</span><br><span style='color: red;'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Strong</span>" },
                        { value: 450, name: "App Designs", tooltip: "<span style='font-weight: 600;'>App Designs</span><br><span style='color: red;'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                        { value: 490, name: "Web Designs", tooltip: "<span style='font-weight: 600;'>Web Designs</span><br><span style='color: red;'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Expert</span>" },
                    ],
                    itemStyle: {
                        color: "#fc6868",
                    },
                    tooltip: {
                        formatter: function (params) {
                            return params.data.tooltip;
                        },
                    },
                },
            ],
        };

        const mobiledata = {
            ...pieChartOptions,
            title: {
                text: "Flutter Development",
                left: "center",
                top: 20,
                textStyle: {
                    color: "rgba(255, 255, 255, 0.3)",
                },
            },
            series: [
                {
                    ...pieChartOptions.series[0],
                    data: [
                        { value: 250, name: "State Managment", tooltip: "<span style='font-weight: 600;'>State Managment</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Intermediate</span>" },
                        { value: 410, name: "Widgets", tooltip: "<span style='font-weight: 600;'>Custom Widgets</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                        { value: 450, name: "Firebase Integration", tooltip: "<span style='font-weight: 600;'>Firebase Integration</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Expert</span>" },
                        { value: 490, name: "Cross-Platform Apps", tooltip: "<span style='font-weight: 600;'>Cross-Platform Apps</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                    ],
                    itemStyle: {
                        color: "rgb(48, 184, 246)",
                    },
                    tooltip: {
                        formatter: function (params) {
                            return params.data.tooltip;
                        },
                    },
                },
            ],
        };
        const dotnetdata = {
            ...pieChartOptions,
            title: {
                text: ".NET Development",
                left: "center",
                top: 20,
                textStyle: {
                    color: "rgba(255, 255, 255, 0.3)",
                },
            },
            series: [
                {
                    ...pieChartOptions.series[0],
                    data: [
                        { value: 190, name: "Web APIs", tooltip: "<span style='font-weight: 600;'>Web APIs</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Intermediate</span>" },

                        { value: 250, name: "ASP.NET core", tooltip: "<span style='font-weight: 600;'>ASP.NET core</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Proficient</span>" },
                        { value: 350, name: "ADO.NET", tooltip: "<span style='font-weight: 600;'>ADO.NET</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Proficient</span>" },
                        { value: 410, name: "Entity Framework", tooltip: "<span style='font-weight: 600;'>Entity Framework</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                        { value: 450, name: "Web Assemblies", tooltip: "<span style='font-weight: 600;'>Web Assemblies</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Proficient</span>" },
                        { value: 490, name: "Blazor Server Apps", tooltip: "<span style='font-weight: 600;'>Blazor Server Apps</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                    ],
                    itemStyle: {
                        color: "rgb(128, 0, 128)",
                    },
                    tooltip: {
                        formatter: function (params) {
                            return params.data.tooltip;
                        },
                    },
                },
            ],
        };
        const databasedata = {
            ...pieChartOptions,
            title: {
                text: "Databases",
                left: "center",
                top: 20,
                textStyle: {
                    color: "rgba(255, 255, 255, 0.3)",
                },
            },
            series: [
                {
                    ...pieChartOptions.series[0],
                    data: [
                        { value: 250, name: "MS Access", tooltip: "<span style='font-weight: 600;'>MS Access</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Intermediate</span>" },
                        { value: 350, name: "MongoDB", tooltip: "<span style='font-weight: 600;'>MongoDB</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Proficient</span>" },
                        { value: 410, name: "Firebase", tooltip: "<span style='font-weight: 600;'>Firebase</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Experienced</span>" },
                        { value: 450, name: "MySQL", tooltip: "<span style='font-weight: 600;'>MySQL</span><br><span style='color: rgb(30, 143, 151);'>•</span> <span style='color: yourTextColor; font-weight: 600;'>Expert</span>" },
                    ],
                    itemStyle: {
                        color: "rgb(0, 255, 0 )",
                    },
                    tooltip: {
                        formatter: function (params) {
                            return params.data.tooltip;
                        },
                    },
                },
            ],
        };



        // Create ECharts instances and set options
        const webSkillsChart = echarts.init(
            document.getElementById("customizedPieChart")
        );
        const uiuxSkillsChart = echarts.init(
            document.getElementById("customizedPieChart2")
        );
        const mobilechart = echarts.init(
            document.getElementById("customizedPieChart3")
        );
        const dotnetchart = echarts.init(
            document.getElementById("customizedPieChart4")
        );
        const databasechart = echarts.init(
            document.getElementById("customizedPieChart5")
        );

        webSkillsChart.setOption(webSkillsData);
        uiuxSkillsChart.setOption(uiuxSkillsData);
        mobilechart.setOption(mobiledata);
        dotnetchart.setOption(dotnetdata);
        databasechart.setOption(databasedata);
    </script>