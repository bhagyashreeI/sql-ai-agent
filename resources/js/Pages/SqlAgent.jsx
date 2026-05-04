import { useState } from "react";
import axios from "axios";

export default function SqlAgent() {
    const [prompt, setPrompt] = useState("");
    const [result, setResult] = useState(null);
    const [loading, setLoading] = useState(false)

    const generate = async () => {
        if (!prompt.trim()) return;
        setLoading(true);
        setResult(null); // ✅ clear previous result
        try {
            const res = await axios.post("/generate-query", {
                prompt,
            });

            setResult(res.data);
        } catch (err) {
            setResult({
                error: "Something went wrong",
                details: err?.response?.data || err.message,
            });
        } finally {
            setLoading(false);
        }

    };

    return (
        <div className="p-10 max-w-4xl mx-auto">
            <h1 className="text-3xl font-bold mb-6">
                Laravel SQL AI Agent
            </h1>

            <textarea
                className="border w-full p-4 rounded mb-4"
                rows="5"
                placeholder="Enter your query prompt..."
                value={prompt}
                onChange={(e) => setPrompt(e.target.value)}
            />

            <button
                onClick={generate}
                disabled={loading}
                className={`px-6 py-2 rounded text-white ${loading ? "bg-gray-400" : "bg-black"
                    }`}
            >
                {loading ? "Generating..." : "Generate"}
            </button>

            {/* Loader */}
            {loading && (
                <div className="mt-6 flex items-center gap-2">
                    <div className="w-5 h-5 border-2 border-gray-300 border-t-black rounded-full animate-spin"></div>
                    <span>Processing AI request...</span>
                </div>
            )}

            {/* Result */}
            {result && (
                <pre className="mt-6 bg-gray-100 p-5 rounded text-sm overflow-auto">
                    {JSON.stringify(result, null, 2)}
                </pre>
            )}
        </div>
    );
}